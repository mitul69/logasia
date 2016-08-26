<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TransportBundle\Entity\VehicleRequest;
use TransportBundle\Util\Validater;

class DefaultController extends Controller {
	/**
	 * @Route("/")
	 */
	public function indexAction() {
		return $this->render ( 'TransportBundle:Default:index.html.twig' );
	}
	
	/**
	 * @Route("/monthly/data/{month}/{year}")
	 */
	public function getMonthlyDataAction($month, $year) {
		$firstDate = "$year-$month-01";
		$totalDaysInMonth = date ( 't', strtotime ( $firstDate ) );
		$response = array ();
		$em = $this->getDoctrine ()->getEntityManager ();
		$categories = $em->getRepository ( "TransportBundle:Category" )->findAll ();
		$categoryRequest = array ();
		$categoryArray = array ();
		foreach ( $categories as $category ) {
			$categoryArray [$category->getId ()] = array (
					'id' => $category->getId (),
					'name' => $category->getName () 
			);
			$categoryRequest [$category->getId ()] = array (
					'categoryId' => $category->getId (),
					'price' => 0,
					'qty' => 0 
			);
		}
		
		for($i = 0; $i < $totalDaysInMonth; $i ++) {
			$date = date ( "Y-m-d", strtotime ( $firstDate . "+$i days" ) );
			$day = date ( "D", strtotime ( $firstDate . "+$i days" ) );
			$row = array ();
			$row ['date'] = $date;
			$row ['day'] = $day;
			$row ['dayNumber'] = $i + 1;
			$row ['requests'] = $categoryRequest;
			$response [$date] = $row;
		}
		
		foreach ( $categories as $category ) {
			$requests = $em->getRepository ( "TransportBundle:VehicleRequest" )->getRequestByMonth ( $month, $year, $category->getId () );
			foreach ( $requests as $request ) {
				$date = $request->getDate ()->format ( "Y-m-d" );
				$response [$date] ['requests'] [$category->getId ()] ['price'] = $request->getPrice ();
				$response [$date] ['requests'] [$category->getId ()] ['qty'] = $request->getNumberOfVehicles ();
			}
		}
		return new JsonResponse ( array (
				'data' => $response,
				'categories' => $categoryArray 
		) );
	}
	/**
	 * @Route("/save/")
	 */
	public function saveAction(Request $request) {
		if ($request->getMethod () == "POST") {
			$data = $request->getContent ();
			$postData = json_decode ( $data, true );
			$date = new \DateTime ();
			$month = $postData ['month'] + 1;
			$date->setDate ( $postData ['year'], $month, $postData ['day'] );
			$categoryId = $postData ['request'] ['categoryId'];
			$em = $this->getDoctrine ()->getEntityManager ();
			$category = $em->getRepository ( "TransportBundle:Category" )->find ( $categoryId );
			if ($category) {
				if ($category->getNumberOfVehicles () < $postData ['request'] ['qty']) {
					return new JsonResponse ( array (
							'status' => 400,
							'message' => "You can not add more then " . $category->getNumberOfVehicles () . " vehicles" 
					) );
				}
				if ($category->getId () == 3) {
					$validateCategory = $em->getRepository ( "TransportBundle:Category" )->find ( 2 );
					$checkRequestForTruck = $em->getRepository ( "TransportBundle:VehicleRequest" )->findOneBy ( array (
							'category' => $validateCategory,
							'date' => $date 
					) );
					if ($checkRequestForTruck && $checkRequestForTruck->getNumberOfVehicles () == 0) {
						return new JsonResponse ( array (
								'status' => 400,
								'message' => "You can not request for only trailer please first request for the truck" 
						) );
					}
				}
				if($category->getId () == 2 && $data ['availibility'] == "0"){
					$this->resetDateToZero($date);
				}
				$requests = $em->getRepository ( "TransportBundle:VehicleRequest" )->findOneBy ( array (
						'category' => $category,
						'date' => $date 
				) );
				if (! $requests) {
					$requests = new VehicleRequest ();
				}
				$requests->setCategory ( $category );
				$requests->setDate ( $date );
				$requests->setPrice ( $postData ['request'] ['price'] );
				$requests->setNumberOfVehicles ( $postData ['request'] ['qty'] );
				$em->persist ( $requests );
				$em->flush ();
				return new JsonResponse ( array (
						'status' => 200,
						'message' => "Data Saved." 
				) );
			} else {
				return new JsonResponse ( array (
						'status' => 400,
						'message' => "Invalid Categoty." 
				) );
			}
		} else {
			return new JsonResponse ( array (
					'status' => 400,
					'message' => "Method not allow." 
			) );
		}
	}
	
	/**
	 * @Route("/bulk/operation/")
	 */
	public function saveBulkData(Request $request) {
		if ($request->getMethod () == "POST") {
			
			$em = $this->getDoctrine ()->getEntityManager ();
			
			$data = $request->getContent ();
			$postData = json_decode ( $data, true );
			$validater = new Validater ();
			$result = $validater->validateForm ( $postData ['bulkData'] );
			if($result !== true){
				return new JsonResponse ( array (
						'status' => 400,
						'message' => $result
				) );
			}
			$categoryId = $postData ['bulkData'] ['category'];
			$category = $em->getRepository ( "TransportBundle:Category" )->find ( $categoryId );
			
			
			if ($category) {
					if ($postData ['bulkData'] ['availibility']) {
						if ($category->getNumberOfVehicles () < $postData ['bulkData'] ['availibility']) {
							return new JsonResponse ( array (
									'status' => 400,
									'message' => "You can not add more then " . $category->getNumberOfVehicles () . " vehicles" 
							) );
						}
					}
					$this->saveData ( $category, $postData ['bulkData'] );
					return new JsonResponse ( array (
							'status' => 200,
							'message' => "Data Saved." 
					) );
				
			} else {
				return new JsonResponse ( array (
						'status' => 400,
						'message' => "Invalid Categoty." 
				) );
			}
		} else {
			return new JsonResponse ( array (
					'status' => 400,
					'message' => "Method not allow." 
			) );
		}
	}
	private function saveData($category, $data) {
		$em = $this->getDoctrine ()->getEntityManager ();
		$fromDate = $data ['fromDate'];
		$toDate = $data ['toDate'];
		while ( $fromDate <= $toDate ) {
			$date = new \DateTime ();
			$date->setTimestamp ( strtotime ( $fromDate ) );
			
			if ($category->getId () == 3) {
				$validateCategory = $em->getRepository ( "TransportBundle:Category" )->find ( 2 );
				$checkRequestForTruck = $em->getRepository ( "TransportBundle:VehicleRequest" )->findOneBy ( array (
						'category' => $validateCategory,
						'date' => $date 
				) );
				if ($checkRequestForTruck && $checkRequestForTruck->getNumberOfVehicles () >= 1) {
					if (Validater::validateSaveDate ( $data, $date )) {
						$this->saveRecordForDate ( $data, $date, $category );
					}
				}
			} else {
				if (Validater::validateSaveDate ( $data, $date )) {
					$this->saveRecordForDate ( $data, $date, $category );
					if($category->getId () == 2 && $data ['availibility'] == "0"){
						$this->resetDateToZero($date);
					}
				}
			}
			$fromDate = date ( "Y-m-d", strtotime ( $fromDate . "+1 days" ) );
		}
	}
	private function saveRecordForDate($data, $date, $category) {
		$em = $this->getDoctrine ()->getEntityManager ();
		$requests = $em->getRepository ( "TransportBundle:VehicleRequest" )->findOneBy ( array (
				'category' => $category,
				'date' => $date 
		) );
		if (! $requests) {
			$requests = new VehicleRequest ();
			$requests->setPrice ( 0 );
			$requests->setNumberOfVehicles ( 0 );
		}
		$requests->setCategory ( $category );
		$requests->setDate ( $date );
		if ($data ['availibility'] || $data ['price'] == 0){
			$requests->setNumberOfVehicles ( $data ['availibility'] );
		}
		if ($data ['price'] || $data ['price'] == 0) {
			$requests->setPrice ( $data ['price'] );
		}
		$em->persist ( $requests );
		$em->flush ();
	}
	
	private function resetDateToZero($date){
		$em = $this->getDoctrine ()->getEntityManager ();
		$validateCategory = $em->getRepository ( "TransportBundle:Category" )->find ( 3 );
		$checkRequestForTruck = $em->getRepository ( "TransportBundle:VehicleRequest" )->findOneBy ( array (
				'category' => $validateCategory,
				'date' => $date
		));
		
		if ($checkRequestForTruck) {
			$checkRequestForTruck->setNumberOfVehicles ( 0 );
			$checkRequestForTruck->setPrice ( 0 );
			$em->persist ( $checkRequestForTruck );
			$em->flush ();
		}
	}
}
