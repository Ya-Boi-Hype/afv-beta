@extends('layouts.master')
@section('title', 'Home')

@section('head')
  @parent
  <link href="https://fonts.googleapis.com/css?family=Archivo+Black:150,400,400i" rel="stylesheet">
  <style>
    .card{
        background-color: transparent;
    }
    .sub {
      color: #000;
      letter-spacing: .5em;
    }
    .glitch-wrapper {
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .glitch {
      color: white;
      font-family: 'Archivo Black';
      font-size: 100px;
      text-transform: uppercase;
      position: relative;
      display: inline-block;
    }
    .glitch::before,
    .glitch::after {
      content: attr(data-text);
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: transparent;
    }
    .glitch::before {
      left: 2px;
      text-shadow: -2px 0 #49FC00;
      clip: rect(24px, 550px, 90px, 0);
      animation: glitch-anim-2 3s infinite linear alternate-reverse;
    }
    .glitch::after {
      left: -2px;
      text-shadow: -2px 0 #b300fc;
      clip: rect(85px, 550px, 140px, 0);
      animation: glitch-anim 2.5s infinite linear alternate-reverse;
    }
    @-webkit-keyframes glitch-anim {
      0% {
        clip: rect(78px, 9999px, 76px, 0);
      }
      4.166666666666666% {
        clip: rect(101px, 9999px, 60px, 0);
      }
      8.333333333333332% {
        clip: rect(78px, 9999px, 75px, 0);
      }
      12.5% {
        clip: rect(21px, 9999px, 123px, 0);
      }
      16.666666666666664% {
        clip: rect(4px, 9999px, 86px, 0);
      }
      20.833333333333336% {
        clip: rect(7px, 9999px, 96px, 0);
      }
      25% {
        clip: rect(87px, 9999px, 12px, 0);
      }
      29.166666666666668% {
        clip: rect(75px, 9999px, 3px, 0);
      }
      33.33333333333333% {
        clip: rect(104px, 9999px, 141px, 0);
      }
      37.5% {
        clip: rect(81px, 9999px, 60px, 0);
      }
      41.66666666666667% {
        clip: rect(8px, 9999px, 36px, 0);
      }
      45.83333333333333% {
        clip: rect(88px, 9999px, 102px, 0);
      }
      50% {
        clip: rect(68px, 9999px, 93px, 0);
      }
      54.166666666666664% {
        clip: rect(104px, 9999px, 40px, 0);
      }
      58.333333333333336% {
        clip: rect(133px, 9999px, 146px, 0);
      }
      62.5% {
        clip: rect(147px, 9999px, 7px, 0);
      }
      66.66666666666666% {
        clip: rect(42px, 9999px, 103px, 0);
      }
      70.83333333333334% {
        clip: rect(32px, 9999px, 148px, 0);
      }
      75% {
        clip: rect(36px, 9999px, 134px, 0);
      }
      79.16666666666666% {
        clip: rect(32px, 9999px, 125px, 0);
      }
      83.33333333333334% {
        clip: rect(139px, 9999px, 18px, 0);
      }
      87.5% {
        clip: rect(95px, 9999px, 122px, 0);
      }
      91.66666666666666% {
        clip: rect(96px, 9999px, 128px, 0);
      }
      95.83333333333334% {
        clip: rect(17px, 9999px, 144px, 0);
      }
      100% {
        clip: rect(20px, 9999px, 146px, 0);
      }
    }
    @keyframes glitch-anim {
      0% {
        clip: rect(78px, 9999px, 76px, 0);
      }
      4.166666666666666% {
        clip: rect(101px, 9999px, 60px, 0);
      }
      8.333333333333332% {
        clip: rect(78px, 9999px, 75px, 0);
      }
      12.5% {
        clip: rect(21px, 9999px, 123px, 0);
      }
      16.666666666666664% {
        clip: rect(4px, 9999px, 86px, 0);
      }
      20.833333333333336% {
        clip: rect(7px, 9999px, 96px, 0);
      }
      25% {
        clip: rect(87px, 9999px, 12px, 0);
      }
      29.166666666666668% {
        clip: rect(75px, 9999px, 3px, 0);
      }
      33.33333333333333% {
        clip: rect(104px, 9999px, 141px, 0);
      }
      37.5% {
        clip: rect(81px, 9999px, 60px, 0);
      }
      41.66666666666667% {
        clip: rect(8px, 9999px, 36px, 0);
      }
      45.83333333333333% {
        clip: rect(88px, 9999px, 102px, 0);
      }
      50% {
        clip: rect(68px, 9999px, 93px, 0);
      }
      54.166666666666664% {
        clip: rect(104px, 9999px, 40px, 0);
      }
      58.333333333333336% {
        clip: rect(133px, 9999px, 146px, 0);
      }
      62.5% {
        clip: rect(147px, 9999px, 7px, 0);
      }
      66.66666666666666% {
        clip: rect(42px, 9999px, 103px, 0);
      }
      70.83333333333334% {
        clip: rect(32px, 9999px, 148px, 0);
      }
      75% {
        clip: rect(36px, 9999px, 134px, 0);
      }
      79.16666666666666% {
        clip: rect(32px, 9999px, 125px, 0);
      }
      83.33333333333334% {
        clip: rect(139px, 9999px, 18px, 0);
      }
      87.5% {
        clip: rect(95px, 9999px, 122px, 0);
      }
      91.66666666666666% {
        clip: rect(96px, 9999px, 128px, 0);
      }
      95.83333333333334% {
        clip: rect(17px, 9999px, 144px, 0);
      }
      100% {
        clip: rect(20px, 9999px, 146px, 0);
      }
    }
    @-webkit-keyframes glitch-anim-2 {
      6.666666666666667% {
        clip: rect(63px, 9999px, 51px, 0);
      }
      10% {
        clip: rect(74px, 9999px, 142px, 0);
      }
      13.333333333333334% {
        clip: rect(143px, 9999px, 14px, 0);
      }
      16.666666666666664% {
        clip: rect(146px, 9999px, 146px, 0);
      }
      20% {
        clip: rect(2px, 9999px, 124px, 0);
      }
      23.333333333333332% {
        clip: rect(84px, 9999px, 83px, 0);
      }
      26.666666666666668% {
        clip: rect(26px, 9999px, 64px, 0);
      }
      30% {
        clip: rect(82px, 9999px, 118px, 0);
      }
      33.33333333333333% {
        clip: rect(48px, 9999px, 111px, 0);
      }
      36.666666666666664% {
        clip: rect(24px, 9999px, 24px, 0);
      }
      40% {
        clip: rect(141px, 9999px, 102px, 0);
      }
      43.333333333333336% {
        clip: rect(88px, 9999px, 48px, 0);
      }
      46.666666666666664% {
        clip: rect(127px, 9999px, 149px, 0);
      }
      50% {
        clip: rect(79px, 9999px, 55px, 0);
      }
      53.333333333333336% {
        clip: rect(44px, 9999px, 149px, 0);
      }
      56.666666666666664% {
        clip: rect(136px, 9999px, 92px, 0);
      }
      60% {
        clip: rect(90px, 9999px, 111px, 0);
      }
      63.33333333333333% {
        clip: rect(37px, 9999px, 54px, 0);
      }
      66.66666666666666% {
        clip: rect(1px, 9999px, 115px, 0);
      }
      70% {
        clip: rect(103px, 9999px, 75px, 0);
      }
      73.33333333333333% {
        clip: rect(141px, 9999px, 114px, 0);
      }
      76.66666666666667% {
        clip: rect(145px, 9999px, 113px, 0);
      }
      80% {
        clip: rect(0px, 9999px, 135px, 0);
      }
      83.33333333333334% {
        clip: rect(78px, 9999px, 14px, 0);
      }
      86.66666666666667% {
        clip: rect(46px, 9999px, 70px, 0);
      }
      90% {
        clip: rect(45px, 9999px, 5px, 0);
      }
      93.33333333333333% {
        clip: rect(46px, 9999px, 86px, 0);
      }
      96.66666666666667% {
        clip: rect(104px, 9999px, 143px, 0);
      }
      100% {
        clip: rect(141px, 9999px, 77px, 0);
      }
    }
    @keyframes glitch-anim-2 {
      6.666666666666667% {
        clip: rect(63px, 9999px, 51px, 0);
      }
      10% {
        clip: rect(74px, 9999px, 142px, 0);
      }
      13.333333333333334% {
        clip: rect(143px, 9999px, 14px, 0);
      }
      16.666666666666664% {
        clip: rect(146px, 9999px, 146px, 0);
      }
      20% {
        clip: rect(2px, 9999px, 124px, 0);
      }
      23.333333333333332% {
        clip: rect(84px, 9999px, 83px, 0);
      }
      26.666666666666668% {
        clip: rect(26px, 9999px, 64px, 0);
      }
      30% {
        clip: rect(82px, 9999px, 118px, 0);
      }
      33.33333333333333% {
        clip: rect(48px, 9999px, 111px, 0);
      }
      36.666666666666664% {
        clip: rect(24px, 9999px, 24px, 0);
      }
      40% {
        clip: rect(141px, 9999px, 102px, 0);
      }
      43.333333333333336% {
        clip: rect(88px, 9999px, 48px, 0);
      }
      46.666666666666664% {
        clip: rect(127px, 9999px, 149px, 0);
      }
      50% {
        clip: rect(79px, 9999px, 55px, 0);
      }
      53.333333333333336% {
        clip: rect(44px, 9999px, 149px, 0);
      }
      56.666666666666664% {
        clip: rect(136px, 9999px, 92px, 0);
      }
      60% {
        clip: rect(90px, 9999px, 111px, 0);
      }
      63.33333333333333% {
        clip: rect(37px, 9999px, 54px, 0);
      }
      66.66666666666666% {
        clip: rect(1px, 9999px, 115px, 0);
      }
      70% {
        clip: rect(103px, 9999px, 75px, 0);
      }
      73.33333333333333% {
        clip: rect(141px, 9999px, 114px, 0);
      }
      76.66666666666667% {
        clip: rect(145px, 9999px, 113px, 0);
      }
      80% {
        clip: rect(0px, 9999px, 135px, 0);
      }
      83.33333333333334% {
        clip: rect(78px, 9999px, 14px, 0);
      }
      86.66666666666667% {
        clip: rect(46px, 9999px, 70px, 0);
      }
      90% {
        clip: rect(45px, 9999px, 5px, 0);
      }
      93.33333333333333% {
        clip: rect(46px, 9999px, 86px, 0);
      }
      96.66666666666667% {
        clip: rect(104px, 9999px, 143px, 0);
      }
      100% {
        clip: rect(141px, 9999px, 77px, 0);
      }
    }

  </style>
@endsection

@section('content')
<div class="content flex-fill d-flex">
  <div class="col flex-fill">
      <div class="glitch-wrapper">
        <div class="glitch" data-text="{{ $exception->getStatusCode() }}">{{ $exception->getStatusCode() }}</div>
      </div>
  </div>
</div>
@endsection