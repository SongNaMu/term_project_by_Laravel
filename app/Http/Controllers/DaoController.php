<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use resources\views;

class DaoController extends Controller
{
    //
    public function index(){
      $Bdao = new dao\BoardDao();
      $totalCount = $Bdao->getNumMsgs();
      $currentPage = requestValue("page");
      if($currentPage < 1 | !$currentPage)
        $currentPage = 1;
      $msgs = $Bdao->getManyMesgs(NUM_LINES*($currentPage-1),NUM_LINES);

      session_start();


      $startPage = floor(($currentPage-1)/NUM_PAGE_LINKS)*NUM_PAGE_LINKS+1;
      $endPage = $startPage + NUM_PAGE_LINKS - 1;
      $totalPage = ceil($totalCount["count"]/NUM_LINES);

      if($endPage > $totalPage)
        $endPage = $totalPage;

      $prev = false;
      $next = false;

      if($startPage == 1)
        $prev = true;

      if($endPage == $totalPage)
        $next = true;

      $startRecord = ($currentPage-1)*NUM_LINES;

      return view('index')->with('msgs',$msgs)->with('startPage', $startPage)->with('endPage',$endPage)->with('totalPage',$totalPage)->with('prev',$prev)->with('next',$next)->with('currentPage',$currentPage);
    }
}
