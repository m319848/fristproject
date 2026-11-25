<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Fund X · Live Forex</title>
    <!-- TradingView Widget Library -->
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Syne:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            line-height: 1.4
        }

        :root,
        [data-theme="dark"] {
            --bg: #0d0f14;
            --bg2: #131720;
            --bg3: #1a1f2e;
            --bg4: #222840;
            --bdr: #2a3050;
            --t1: #e2e8f8;
            --t2: #7a85a8;
            --t3: #3d4668;
            --grn: #00d4aa;
            --grnl: #00d4aa22;
            --red: #ff4d6a;
            --redl: #ff4d6a22;
            --blu: #4f7cff;
            --blul: #4f7cff22;
            --gold: #f5c842;
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
            --up-c: #26a69a;
            --dn-c: #ef5350
        }

        [data-theme="light"] {
            --bg: #f0f2f8;
            --bg2: #ffffff;
            --bg3: #e8ebf5;
            --bg4: #dde2f0;
            --bdr: #c8cfe6;
            --t1: #1a2040;
            --t2: #5a6490;
            --t3: #a0aac8;
            --grn: #00a882;
            --grnl: #00a88218;
            --red: #e03050;
            --redl: #e0305018;
            --blu: #3060e8;
            --blul: #3060e818;
            --gold: #d4a200;
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            --up-c: #00a882;
            --dn-c: #e03050
        }

        #app {
            display: flex;
            flex-direction: column;
            height: 100vh;
            height: 100dvh;
            background: var(--bg);
            color: var(--t1);
            transition: background .3s, color .3s
        }

        #topbar {
            height: 44px;
            display: flex;
            align-items: center;
            padding: 0 10px;
            gap: 4px;
            border-bottom: 1px solid var(--bdr);
            flex-shrink: 0;
            background: var(--bg2);
            position: relative;
            z-index: 100
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-right: 6px;
            user-select: none;
            flex-shrink: 0
        }

        .logo-icon {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 14px;
            color: #fff;
            letter-spacing: -1px
        }

        .logo-text {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 13px;
            color: var(--t1);
            white-space: nowrap
        }

        .btn {
            background: none;
            border: none;
            color: var(--t2);
            padding: 4px 8px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 11px;
            font-family: inherit;
            transition: all .15s;
            white-space: nowrap
        }

        .btn:hover,
        .btn.act {
            background: var(--bg3);
            color: var(--t1)
        }

        .btn.act {
            color: var(--blu);
            font-weight: 600
        }

        .ibtn {
            background: none;
            border: none;
            color: var(--t2);
            width: 28px;
            height: 28px;
            cursor: pointer;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
            transition: all .15s
        }

        .ibtn:hover {
            background: var(--bg3);
            color: var(--t1)
        }

        .sep {
            width: 1px;
            height: 20px;
            background: var(--bdr);
            margin: 0 3px;
            flex-shrink: 0
        }

        .spc {
            flex: 1
        }

        #sym-select {
            background: var(--bg3);
            border: 1px solid var(--bdr);
            color: var(--t1);
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 12px;
            font-family: inherit;
            cursor: pointer;
            outline: none
        }

        #sym-select:focus {
            border-color: var(--blu)
        }

        .theme-btn {
            background: none;
            border: 1px solid var(--bdr);
            color: var(--t2);
            width: 28px;
            height: 28px;
            cursor: pointer;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all .2s;
            flex-shrink: 0
        }

        .theme-btn:hover {
            border-color: var(--blu);
            color: var(--blu);
            background: var(--blul)
        }

        .topbar-prices {
            display: flex;
            gap: 20px;
            padding: 0 12px;
            font-size: 11px;
            align-items: center;
            flex-shrink: 0
        }

        .topbar-prices .lbl {
            color: var(--t3);
            font-size: 10px
        }

        .topbar-prices .bid {
            color: var(--red);
            font-weight: 700;
            font-size: 13px
        }

        .topbar-prices .ask {
            color: var(--grn);
            font-weight: 700;
            font-size: 13px
        }

        .topbar-prices .spread-val {
            color: var(--t3);
            font-size: 10px
        }

        #mid {
            display: flex;
            flex: 1;
            overflow: hidden;
            min-height: 0
        }

        #ltb {
            width: 44px;
            border-right: 1px solid var(--bdr);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 6px 0;
            gap: 2px;
            flex-shrink: 0;
            overflow-y: auto;
            background: var(--bg2)
        }

        .tbtn {
            width: 32px;
            height: 32px;
            background: none;
            border: none;
            color: var(--t2);
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
            font-size: 11px;
            position: relative
        }

        .tbtn:hover {
            background: var(--bg3);
            color: var(--t1)
        }

        .tbtn.act {
            color: var(--blu);
            background: var(--blul)
        }

        .tbtn-tip {
            position: absolute;
            left: 38px;
            background: var(--bg4);
            color: var(--t1);
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity .15s;
            z-index: 200;
            border: 1px solid var(--bdr)
        }

        .tbtn:hover .tbtn-tip {
            opacity: 1
        }

        .tsep {
            width: 22px;
            height: 1px;
            background: var(--bdr);
            margin: 3px 0
        }

        #center {
            display: flex;
            flex-direction: column;
            flex: 1;
            overflow: hidden;
            min-width: 0
        }

        #cinfo {
            height: 34px;
            display: flex;
            align-items: center;
            padding: 0 12px;
            gap: 10px;
            border-bottom: 1px solid var(--bdr);
            flex-shrink: 0;
            background: var(--bg2);
            overflow: hidden
        }

        .live-dot-sm {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--grn);
            animation: pulse 1.5s infinite;
            flex-shrink: 0
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 0 0 var(--grn)
            }

            50% {
                opacity: .5;
                box-shadow: 0 0 0 4px transparent
            }
        }

        .sname {
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            font-family: 'Syne', sans-serif
        }

        .ohlc {
            display: flex;
            gap: 10px;
            font-size: 10px;
            color: var(--t2);
            white-space: nowrap
        }

        .ohlc span {
            display: flex;
            align-items: center;
            gap: 3px
        }

        .ohlc b {
            color: var(--t3);
            font-weight: 400
        }

        .pchg {
            font-size: 11px;
            white-space: nowrap;
            padding: 2px 7px;
            border-radius: 4px;
            font-weight: 600
        }

        .pchg.up {
            color: var(--grn);
            background: var(--grnl)
        }

        .pchg.dn {
            color: var(--red);
            background: var(--redl)
        }

        #cwrap {
            flex: 1;
            position: relative;
            overflow: hidden;
            min-height: 0;
            background: var(--bg)
        }

        #chart-main {
            width: 100%;
            height: 100%
        }

        #multi-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            width: 100%;
            height: 100%;
            gap: 1px;
            background: var(--bdr)
        }

        .chart-cell {
            background: var(--bg);
            position: relative;
            overflow: hidden
        }

        .chart-cell-label {
            position: absolute;
            top: 6px;
            left: 8px;
            font-size: 10px;
            color: var(--t2);
            z-index: 10;
            background: var(--bg2);
            padding: 2px 7px;
            border-radius: 4px;
            border: 1px solid var(--bdr);
            pointer-events: none;
            font-weight: 600
        }

        #live-badge {
            position: absolute;
            top: 10px;
            right: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(13, 15, 20, 0.85);
            border: 1px solid var(--bdr);
            border-radius: 5px;
            padding: 4px 10px;
            font-size: 10px;
            color: var(--t2);
            z-index: 10;
            pointer-events: none
        }

        [data-theme="light"] #live-badge {
            background: rgba(240, 242, 248, 0.95)
        }

        #tfbar {
            height: 32px;
            display: flex;
            align-items: center;
            padding: 0 10px;
            gap: 2px;
            border-top: 1px solid var(--bdr);
            flex-shrink: 0;
            background: var(--bg2)
        }

        .tf-grp {
            display: flex;
            gap: 1px
        }

        .tfclk {
            margin-left: auto;
            font-size: 11px;
            color: var(--t2);
            font-family: 'JetBrains Mono', monospace;
            white-space: nowrap
        }

        .view-switcher {
            display: flex;
            gap: 2px;
            margin-left: 8px;
            padding-left: 8px;
            border-left: 1px solid var(--bdr)
        }

        .vbtn {
            background: none;
            border: none;
            color: var(--t2);
            padding: 3px 7px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 10px;
            font-family: inherit;
            transition: all .15s
        }

        .vbtn:hover {
            background: var(--bg3);
            color: var(--t1)
        }

        .vbtn.act {
            background: var(--blul);
            color: var(--blu);
            font-weight: 600
        }

        #wl {
            width: 210px;
            border-left: 1px solid var(--bdr);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            overflow: hidden;
            background: var(--bg2)
        }

        #wlh {
            height: 32px;
            display: flex;
            align-items: center;
            padding: 0 10px;
            border-bottom: 1px solid var(--bdr);
            font-size: 10px;
            color: var(--t3);
            flex-shrink: 0;
            gap: 2px;
            font-weight: 600;
            letter-spacing: .05em
        }

        #wlh .sc {
            flex: 1
        }

        #wls {
            padding: 4px 8px;
            border-bottom: 1px solid var(--bdr);
            flex-shrink: 0
        }

        #wl-search {
            width: 100%;
            background: var(--bg3);
            border: 1px solid var(--bdr);
            color: var(--t1);
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 11px;
            font-family: inherit;
            outline: none
        }

        #wl-search:focus {
            border-color: var(--blu)
        }

        #wl-search::placeholder {
            color: var(--t3)
        }

        #wlb {
            overflow-y: auto;
            flex: 1
        }

        .wi {
            padding: 6px 10px;
            border-bottom: 1px solid rgba(42, 48, 80, .5);
            cursor: pointer;
            transition: background .12s
        }

        .wi:hover {
            background: var(--bg3)
        }

        .wi.sel {
            background: var(--blul);
            border-left: 2px solid var(--blu)
        }

        .wr1 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2px
        }

        .wsym {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .03em
        }

        .wsp {
            font-size: 8px;
            font-weight: 400;
            color: var(--t3);
            margin-left: 2px;
            vertical-align: middle
        }

        .wchg {
            text-align: right;
            line-height: 1.2
        }

        .wpct {
            font-size: 9px;
            font-weight: 700;
            padding: 1px 5px;
            border-radius: 3px
        }

        .wchg.up .wpct {
            color: var(--grn);
            background: var(--grnl)
        }

        .wchg.dn .wpct {
            color: var(--red);
            background: var(--redl)
        }

        .wchg.flat .wpct {
            color: var(--t2);
            background: var(--bg3)
        }

        .whl {
            font-size: 9px;
            color: var(--t3);
            margin-bottom: 3px
        }

        .wr3 {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 4px
        }

        .wbid {
            font-size: 12px;
            font-weight: 700;
            color: var(--red);
            font-family: 'JetBrains Mono', monospace
        }

        .wask {
            font-size: 12px;
            font-weight: 700;
            color: var(--grn);
            font-family: 'JetBrains Mono', monospace
        }

        .wchg-abs {
            font-size: 9px;
            color: var(--t3)
        }

        #bp {
            height: 180px;
            border-top: 1px solid var(--bdr);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            background: var(--bg2)
        }

        #btabs {
            height: 32px;
            display: flex;
            align-items: center;
            padding: 0 12px;
            gap: 2px;
            border-bottom: 1px solid var(--bdr);
            flex-shrink: 0
        }

        .btab {
            background: none;
            border: none;
            color: var(--t2);
            padding: 6px 12px;
            cursor: pointer;
            font-size: 12px;
            font-family: inherit;
            border-bottom: 2px solid transparent;
            height: 32px;
            display: flex;
            align-items: center;
            margin-bottom: -1px;
            transition: all .15s
        }

        .btab:hover {
            color: var(--t1)
        }

        .btab.act {
            color: var(--t1);
            border-bottom-color: var(--blu)
        }

        .btab-badge {
            background: var(--blu);
            color: #fff;
            font-size: 9px;
            padding: 1px 5px;
            border-radius: 10px;
            margin-left: 5px;
            line-height: 1.4
        }

        #acct {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 5px 14px;
            border-bottom: 1px solid var(--bdr);
            flex-shrink: 0;
            overflow-x: auto
        }

        .ai label {
            color: var(--t3);
            font-size: 9px;
            display: block;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: .05em
        }

        .ai .v {
            font-weight: 600;
            white-space: nowrap;
            font-size: 12px
        }

        .ai .v.loss {
            color: var(--red)
        }

        .ai .v.gain {
            color: var(--grn)
        }

        .cbs {
            margin-left: auto;
            display: flex;
            gap: 3px;
            flex-shrink: 0
        }

        .cbtn {
            background: var(--bg3);
            border: 1px solid var(--bdr);
            color: var(--t2);
            width: 22px;
            height: 22px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            transition: all .15s
        }

        .cbtn:hover {
            color: var(--t1);
            border-color: var(--blu)
        }

        #ptable {
            flex: 1;
            overflow-y: auto
        }

        .th {
            display: grid;
            grid-template-columns: 80px 60px 90px 50px 60px 72px 62px 62px 62px 70px 70px;
            padding: 3px 14px;
            font-size: 9px;
            color: var(--t3);
            border-bottom: 1px solid var(--bdr);
            background: var(--bg2);
            position: sticky;
            top: 0;
            letter-spacing: .04em;
            text-transform: uppercase
        }

        .nop {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 60px;
            color: var(--t3);
            font-size: 11px;
            gap: 4px
        }

        .nop-icon {
            font-size: 20px;
            opacity: .3
        }

        .ct-group {
            display: flex;
            gap: 1px;
            background: var(--bg3);
            border-radius: 5px;
            padding: 2px
        }

        .ct-btn {
            background: none;
            border: none;
            color: var(--t2);
            padding: 3px 7px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 10px;
            font-family: inherit;
            transition: all .15s
        }

        .ct-btn:hover {
            color: var(--t1)
        }

        .ct-btn.act {
            background: var(--bg2);
            color: var(--t1);
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2)
        }

        .ind-badge {
            background: var(--bg4);
            border: 1px solid var(--bdr);
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 10px;
            color: var(--t2);
            cursor: pointer;
            transition: all .15s;
            white-space: nowrap
        }

        .ind-badge:hover {
            border-color: var(--blu);
            color: var(--blu)
        }

        .ind-badge.act {
            border-color: var(--grn);
            color: var(--grn);
            background: var(--grnl)
        }

        #toast-container {
            position: fixed;
            bottom: 200px;
            right: 16px;
            z-index: 2000;
            display: flex;
            flex-direction: column;
            gap: 6px
        }

        .toast {
            background: var(--bg3);
            border: 1px solid var(--bdr);
            border-radius: 6px;
            padding: 8px 14px;
            font-size: 11px;
            color: var(--t1);
            min-width: 220px;
            animation: slideIn .25s ease;
            box-shadow: var(--shadow)
        }

        .toast.success {
            border-left: 3px solid var(--grn)
        }

        .toast.error {
            border-left: 3px solid var(--red)
        }

        .toast.info {
            border-left: 3px solid var(--blu)
        }

        @keyframes slideIn {
            from {
                transform: translateX(40px);
                opacity: 0
            }

            to {
                transform: translateX(0);
                opacity: 1
            }
        }

        .pos-row {
            display: grid;
            grid-template-columns: 80px 60px 90px 50px 60px 72px 62px 62px 62px 70px 70px;
            padding: 4px 14px;
            font-size: 11px;
            border-bottom: 1px solid rgba(42, 48, 80, .3);
            transition: background .1s;
            align-items: center
        }

        .pos-row:hover {
            background: var(--bg3)
        }

        .pos-profit.pos {
            color: var(--grn);
            font-weight: 600
        }

        .pos-profit.neg {
            color: var(--red);
            font-weight: 600
        }

        .close-pos {
            background: var(--redl);
            border: 1px solid var(--red);
            color: var(--red);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9px;
            cursor: pointer;
            font-family: inherit;
            transition: all .15s;
            white-space: nowrap
        }

        .close-pos:hover {
            background: var(--red);
            color: #fff
        }

        /* live price flash */
        @keyframes flashGreen {
            0% {
                background: rgba(0, 212, 170, .18)
            }

            100% {
                background: transparent
            }
        }

        @keyframes flashRed {
            0% {
                background: rgba(255, 77, 106, .18)
            }

            100% {
                background: transparent
            }
        }

        .flash-up {
            animation: flashGreen .6s ease
        }

        .flash-dn {
            animation: flashRed .6s ease
        }

        /* data source badge */
        #data-src {
            font-size: 9px;
            color: var(--grn);
            background: var(--grnl);
            padding: 2px 7px;
            border-radius: 4px;
            border: 1px solid var(--grn);
            flex-shrink: 0
        }

        /* mobile */
        #mobile-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 52px;
            background: var(--bg2);
            border-top: 1px solid var(--bdr);
            z-index: 500;
            flex-direction: row;
            align-items: center;
            justify-content: space-around;
            padding: 0 4px
        }

        .mnav-btn {
            flex: 1;
            height: 100%;
            background: none;
            border: none;
            color: var(--t3);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2px;
            font-size: 9px;
            font-family: 'JetBrains Mono', monospace;
            cursor: pointer;
            transition: color .15s;
            -webkit-tap-highlight-color: transparent
        }

        .mnav-btn i {
            font-size: 17px
        }

        .mnav-btn.act {
            color: var(--blu)
        }

        .mobile-panel {
            display: none;
            position: fixed;
            inset: 44px 0 52px 0;
            background: var(--bg);
            z-index: 400;
            flex-direction: column;
            overflow: hidden
        }

        .mobile-panel.open {
            display: flex
        }

        .m-panel-head {
            padding: 10px 14px 8px;
            border-bottom: 1px solid var(--bdr);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .m-panel-title {
            font-size: 13px;
            font-weight: 700;
            font-family: 'Syne', sans-serif;
            color: var(--t1)
        }

        #m-watchlist-body {
            overflow-y: auto;
            flex: 1;
            -webkit-overflow-scrolling: touch
        }

        .m-wi {
            padding: 13px 14px;
            border-bottom: 1px solid rgba(42, 48, 80, .4);
            display: grid;
            grid-template-columns: 1fr auto;
            grid-template-rows: auto auto auto;
            gap: 2px 8px;
            cursor: pointer;
            transition: background .1s;
            -webkit-tap-highlight-color: transparent
        }

        .m-wi:active {
            background: var(--bg3)
        }

        .m-wi.sel {
            background: var(--blul);
            border-left: 3px solid var(--blu)
        }

        .m-wi-sym {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .03em;
            grid-row: 1;
            grid-column: 1;
            color: var(--t3)
        }

        .m-wi-cat {
            font-size: 10px;
            color: var(--t3);
            grid-row: 2;
            grid-column: 1
        }

        .m-wi-prices {
            display: flex;
            gap: 8px;
            align-items: baseline;
            grid-row: 3;
            grid-column: 1
        }

        .m-wi-bid {
            font-size: 15px;
            font-weight: 700;
            color: var(--red);
            font-family: 'JetBrains Mono', monospace
        }

        .m-wi-ask {
            font-size: 13px;
            font-weight: 600;
            color: var(--grn);
            font-family: 'JetBrains Mono', monospace
        }

        .m-wi-right {
            grid-row: 1/4;
            grid-column: 2;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: center;
            gap: 5px
        }

        .m-wi-chg {
            font-size: 12px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 5px
        }

        .m-wi-chg.up {
            color: var(--grn);
            background: var(--grnl)
        }

        .m-wi-chg.dn {
            color: var(--red);
            background: var(--redl)
        }

        .m-wi-chg.flat {
            color: var(--t2);
            background: var(--bg3)
        }

        .m-acct-strip {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            padding: 8px 14px;
            border-bottom: 1px solid var(--bdr);
            gap: 8px;
            flex-shrink: 0;
            background: var(--bg2)
        }

        .m-ai label {
            font-size: 9px;
            color: var(--t3);
            text-transform: uppercase;
            letter-spacing: .05em;
            display: block
        }

        .m-ai .v {
            font-size: 13px;
            font-weight: 700
        }

        .m-ai .v.gain {
            color: var(--grn)
        }

        .m-ai .v.loss {
            color: var(--red)
        }

        #m-pos-list {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 8px
        }

        .m-pos-card {
            margin: 8px 12px;
            background: var(--bg2);
            border: 1px solid var(--bdr);
            border-radius: 10px;
            padding: 12px 14px
        }

        .m-pos-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px
        }

        .m-pos-sym {
            font-size: 14px;
            font-weight: 700;
            font-family: 'Syne', sans-serif
        }

        .m-pos-side {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 5px;
            text-transform: uppercase
        }

        .m-pos-side.buy {
            color: var(--grn);
            background: var(--grnl)
        }

        .m-pos-side.sell {
            color: var(--red);
            background: var(--redl)
        }

        .m-pos-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 8px;
            margin-bottom: 10px
        }

        .m-pos-field label {
            font-size: 9px;
            color: var(--t3);
            display: block;
            text-transform: uppercase;
            margin-bottom: 2px
        }

        .m-pos-field .val {
            font-size: 12px;
            font-weight: 600
        }

        .m-pos-profit {
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            padding: 6px 0
        }

        .m-pos-profit.pos {
            color: var(--grn)
        }

        .m-pos-profit.neg {
            color: var(--red)
        }

        .m-close-btn {
            width: 100%;
            padding: 10px;
            background: var(--redl);
            border: 1px solid var(--red);
            color: var(--red);
            border-radius: 7px;
            font-size: 13px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all .15s;
            -webkit-tap-highlight-color: transparent
        }

        .m-close-btn:active {
            background: var(--red);
            color: #fff
        }

        .m-nop {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 20px;
            color: var(--t3);
            gap: 10px;
            font-size: 12px
        }

        .m-nop-icon {
            font-size: 36px;
            opacity: .3
        }

        .m-hist-card {
            margin: 8px 12px;
            background: var(--bg2);
            border: 1px solid var(--bdr);
            border-radius: 8px;
            padding: 10px 12px;
            opacity: .8
        }

        .m-hist-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px
        }

        .m-hist-profit.pos {
            color: var(--grn);
            font-weight: 700;
            font-size: 14px
        }

        .m-hist-profit.neg {
            color: var(--red);
            font-weight: 700;
            font-size: 14px
        }

        .m-hist-meta {
            font-size: 10px;
            color: var(--t3)
        }

        .modal-drag-handle {
            width: 40px;
            height: 4px;
            background: var(--bdr);
            border-radius: 2px;
            margin: 0 auto 14px
        }

        #modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center
        }

        #modal-overlay.open {
            display: flex
        }

        .modal {
            background: var(--bg2);
            border: 1px solid var(--bdr);
            border-radius: 10px;
            padding: 20px 24px;
            width: 340px;
            box-shadow: var(--shadow)
        }

        .modal h3 {
            font-family: 'Syne', sans-serif;
            font-size: 16px;
            margin-bottom: 16px;
            color: var(--t1)
        }

        .modal-row {
            margin-bottom: 12px
        }

        .modal-row label {
            font-size: 10px;
            color: var(--t3);
            display: block;
            margin-bottom: 4px;
            text-transform: uppercase
        }

        .modal-row input,
        .modal-row select {
            width: 100%;
            background: var(--bg3);
            border: 1px solid var(--bdr);
            color: var(--t1);
            padding: 7px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-family: inherit;
            outline: none
        }

        .modal-row input:focus,
        .modal-row select:focus {
            border-color: var(--blu)
        }

        .modal-btns {
            display: flex;
            gap: 8px;
            margin-top: 16px
        }

        .mbtn {
            flex: 1;
            padding: 8px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            font-family: inherit;
            font-weight: 600;
            transition: all .15s
        }

        .mbtn.buy {
            background: var(--grn);
            color: #000
        }

        .mbtn.sell {
            background: var(--red);
            color: #fff
        }

        .mbtn.cancel {
            background: var(--bg3);
            color: var(--t2)
        }

        .mbtn:hover {
            filter: brightness(1.1)
        }

        ::-webkit-scrollbar {
            width: 4px;
            height: 4px
        }

        ::-webkit-scrollbar-track {
            background: transparent
        }

        ::-webkit-scrollbar-thumb {
            background: var(--bg4);
            border-radius: 2px
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--t3)
        }

        @media(max-width:768px) {

            html,
            body {
                -webkit-tap-highlight-color: transparent
            }

            #topbar {
                padding: 0 8px;
                gap: 0
            }

            .logo-text {
                display: none
            }

            .logo {
                margin-right: 4px
            }

            .logo-icon {
                width: 26px;
                height: 26px
            }

            #topbar .sep,
            #topbar .tf-grp,
            #topbar .ct-group,
            #topbar #ind-ma,
            #topbar #ind-bb,
            #topbar #ind-vol,
            #topbar .spc,
            #topbar .topbar-prices,
            #topbar .ibtn,
            #topbar #data-src {
                display: none !important
            }

            #topbar .theme-btn {
                display: flex !important;
                margin-left: 4px
            }

            #sym-select {
                display: block !important;
                max-width: 115px;
                font-size: 12px;
                padding: 4px 6px;
                margin-left: 4px
            }

            #mid {
                overflow: hidden
            }

            #ltb {
                display: none !important
            }

            #wl {
                display: none !important
            }

            #center {
                display: flex !important;
                flex-direction: column;
                flex: 1;
                overflow: hidden
            }

            #cinfo {
                height: 32px;
                padding: 0 10px;
                gap: 6px
            }

            .ohlc {
                display: none
            }

            #pchg {
                font-size: 10px
            }

            .sname {
                font-size: 12px
            }

            #tfbar {
                height: 38px;
                padding: 0 6px;
                overflow-x: auto;
                overflow-y: hidden;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                gap: 2px;
                flex-wrap: nowrap;
                white-space: nowrap
            }

            #tfbar::-webkit-scrollbar {
                display: none
            }

            .view-switcher {
                margin-left: 0;
                border-left: none;
                padding-left: 0
            }

            .tfclk {
                display: none
            }

            #log-btn,
            .view-switcher .sep {
                display: none
            }

            #tfbar .sep {
                display: none !important
            }

            #bp {
                display: none !important
            }

            #mobile-nav {
                display: flex !important
            }

            #live-badge {
                top: 6px;
                right: 8px;
                padding: 3px 7px;
                font-size: 9px
            }

            #modal-overlay.open {
                align-items: flex-end
            }

            #modal-overlay .modal {
                width: 100%;
                max-height: 90vh;
                border-radius: 16px 16px 0 0;
                overflow-y: auto;
                padding: 8px 18px 32px;
                margin: 0
            }

            #toast-container {
                bottom: 62px;
                right: 10px;
                left: 10px
            }

            .toast {
                min-width: unset;
                width: 100%
            }
        }

        @media(max-width:900px) {
            #wl {
                display: none
            }
        }
    </style>
</head>

<body>
    <div id="app">
        <!-- TOPBAR -->
        <div id="topbar">
            <div class="logo">
                <div class="logo-icon" style="background:linear-gradient(135deg,#4f7cff,#00d4aa)">TX</div>
                <span class="logo-text">Turboex Bot</span>
            </div>
            <div class="sep"></div>
            <select id="sym-select" onchange="selectPairFromTop(this.value)"></select>
            <div class="sep"></div>
            <div class="tf-grp">
                <button class="btn" onclick="setTF('1m',this)">1m</button>
                <button class="btn" onclick="setTF('5m',this)">5m</button>
                <button class="btn" onclick="setTF('15m',this)">15m</button>
                <button class="btn act" onclick="setTF('1H',this)">1H</button>
                <button class="btn" onclick="setTF('4H',this)">4H</button>
                <button class="btn" onclick="setTF('1D',this)">1D</button>
            </div>
            <div class="sep"></div>
            <div class="ct-group">
                <button class="ct-btn act" id="ctype-candle" onclick="setChartType('candle',this)">Candles</button>
                <button class="ct-btn" id="ctype-bar" onclick="setChartType('bar',this)">Bars</button>
                <button class="ct-btn" id="ctype-line" onclick="setChartType('line',this)">Line</button>
                <button class="ct-btn" id="ctype-area" onclick="setChartType('area',this)">Area</button>
            </div>
            <div class="sep"></div>
            <button class="ind-badge" id="ind-ma" onclick="toggleIndicator('ma')">MA</button>
            <button class="ind-badge" id="ind-bb" onclick="toggleIndicator('bb')">BB</button>
            <button class="ind-badge" id="ind-vol" onclick="toggleIndicator('vol')">VOL</button>
            <div class="spc"></div>
            <div id="data-src">● TradingView LIVE</div>
            <div class="topbar-prices" id="tb-prices">
                <div>
                    <div class="lbl">BID</div>
                    <div class="bid" id="tb-bid">—</div>
                </div>
                <div>
                    <div class="lbl">ASK</div>
                    <div class="ask" id="tb-ask">—</div>
                </div>
                <div>
                    <div class="lbl">SPREAD</div>
                    <div class="spread-val" id="tb-spread">—</div>
                </div>
            </div>
            <div class="sep"></div>
            <button class="btn"
                style="background:var(--blul);color:var(--blu);border:1px solid var(--blu);font-weight:600"
                onclick="openTradeModal()">+ Trade</button>
            <div class="sep"></div>
            <button class="theme-btn" id="theme-btn" onclick="toggleTheme()"><span id="theme-icon"><i
                        class="fa-solid fa-sun"></i></span></button>
            <button class="ibtn" onclick="toggleFS()">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M1 5V1h4M9 1h4v4M13 9v4H9M5 13H1V9" />
                </svg>
            </button>
        </div>

        <div id="mid">
            <!-- LEFT TOOLBAR -->
            <div id="ltb">
                <button class="tbtn act" onclick="showToast('Use TradingView chart tools','info')">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor"
                        stroke-width="1.4">
                        <circle cx="8" cy="8" r="4.5" />
                        <line x1="8" y1="1" x2="8" y2="4.5" />
                        <line x1="8" y1="11.5" x2="8" y2="15" />
                        <line x1="1" y1="8" x2="4.5" y2="8" />
                        <line x1="11.5" y1="8" x2="15" y2="8" />
                    </svg>
                    <span class="tbtn-tip">Crosshair</span>
                </button>
                <div class="tsep"></div>
                <button class="tbtn" onclick="showToast('Use TradingView drawing tools','info')">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" stroke="currentColor"
                        stroke-width="1.4">
                        <line x1="1" y1="7.5" x2="14" y2="7.5" />
                        <line x1="1" y1="4" x2="14" y2="4" opacity=".35" />
                        <line x1="1" y1="11" x2="14" y2="11" opacity=".35" />
                    </svg>
                    <span class="tbtn-tip">H-Line</span>
                </button>
                <button class="tbtn" onclick="showToast('Use TradingView drawing tools','info')">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" stroke="currentColor"
                        stroke-width="1.4">
                        <line x1="2" y1="12" x2="12" y2="3" />
                        <circle cx="2" cy="12" r="1.5" fill="currentColor" />
                        <circle cx="12" cy="3" r="1.5" fill="currentColor" />
                    </svg>
                    <span class="tbtn-tip">Trendline</span>
                </button>
                <button class="tbtn" onclick="showToast('Fibonacci via TradingView chart','info')">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" stroke="currentColor"
                        stroke-width="1.4">
                        <line x1="1" y1="3" x2="14" y2="3" />
                        <line x1="1" y1="5.4" x2="14" y2="5.4" opacity=".7" />
                        <line x1="1" y1="7.5" x2="14" y2="7.5" />
                        <line x1="1" y1="9.6" x2="14" y2="9.6" opacity=".7" />
                        <line x1="1" y1="12" x2="14" y2="12" />
                    </svg>
                    <span class="tbtn-tip">Fibonacci</span>
                </button>
                <div class="tsep"></div>
                <button class="tbtn" onclick="showToast('📸 Snapshot saved','success')">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor"
                        stroke-width="1.4">
                        <rect x="1" y="3" width="12" height="9" rx="1.5" />
                        <circle cx="7" cy="7.5" r="2.5" />
                        <path d="M4.5 3V1.5h5V3" />
                    </svg>
                    <span class="tbtn-tip">Snapshot</span>
                </button>
                <button class="tbtn" onclick="showToast('🔔 Alert set','info')">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor"
                        stroke-width="1.4">
                        <path d="M7 1.5a4 4 0 014 4v3.5l1.5 2H1.5L3 9V5.5a4 4 0 014-4z" />
                        <line x1="5.5" y1="11" x2="8.5" y2="11" />
                    </svg>
                    <span class="tbtn-tip">Alert</span>
                </button>
            </div>

            <!-- CENTER -->
            <div id="center">
                <div id="cinfo">
                    <div class="live-dot-sm"></div>
                    <div class="sname" id="sym-label">EUR/USD</div>
                    <div class="ohlc">
                        <span><b>O</b><span id="oo">—</span></span>
                        <span><b>H</b><span id="oh" style="color:var(--grn)">—</span></span>
                        <span><b>L</b><span id="ol" style="color:var(--red)">—</span></span>
                        <span><b>C</b><span id="oc">—</span></span>
                    </div>
                    <div class="pchg up" id="pchg">+0.00%</div>
                    <div class="spc"></div>
                    <div style="font-size:10px;color:var(--t3)" id="candle-timer">Loading…</div>
                </div>
                <div id="cwrap">
                    <div id="chart-main"></div>
                    <div id="multi-grid" style="display:none"></div>
                    <div id="live-badge">
                        <div class="live-dot-sm"></div>
                        <span id="live-sym">LIVE · EUR/USD</span>
                    </div>
                </div>
                <div id="tfbar">
                    <div class="view-switcher">
                        <button class="vbtn act" id="view-single" onclick="setView('single',this)">Single</button>
                        <button class="vbtn" id="view-2x2" onclick="setView('2x2',this)">2×2</button>
                        <button class="vbtn" id="view-1x3" onclick="setView('1x3',this)">1×3</button>
                    </div>
                    <div class="sep" style="margin-left:6px"></div>
                    <button class="btn" onclick="rebuildChart()">↺ Reload</button>
                    <div class="tfclk" id="clk">00:00:00 UTC</div>
                </div>
            </div>

            <!-- WATCHLIST -->
            <div id="wl">
                <div id="wlh"><span class="sc">MARKET WATCH</span><span id="wl-src"
                        style="font-size:9px;color:var(--grn)">● LIVE</span></div>
                <div id="wls"><input id="wl-search" placeholder="Search symbol…" oninput="filterWL(this.value)"></div>
                <div id="wlb"></div>
            </div>
        </div>

        <!-- BOTTOM PANEL -->
        <div id="bp">
            <div id="btabs">
                <button class="btab act" onclick="switchTab(this,'pos-panel')">Positions <span class="btab-badge"
                        id="pos-count">0</span></button>
                <button class="btab" onclick="switchTab(this,'pending-panel')">Pending</button>
                <button class="btab" onclick="switchTab(this,'history-panel')">History <span class="btab-badge"
                        id="hist-count">0</span></button>
            </div>
            <div id="acct">
                <div class="ai"><label>Balance</label>
                    <div class="v" id="acct-bal">$10,000.00</div>
                </div>
                <div class="ai"><label>Equity</label>
                    <div class="v" id="acct-eq">$10,000.00</div>
                </div>
                <div class="ai"><label>Margin Used</label>
                    <div class="v" id="acct-margin">$0.00</div>
                </div>
                <div class="ai"><label>Free Margin</label>
                    <div class="v" id="acct-free">$10,000.00</div>
                </div>
                <div class="ai"><label>Margin Lv</label>
                    <div class="v" id="acct-lvl">—</div>
                </div>
                <div class="ai"><label>P&L</label>
                    <div class="v" id="acct-pnl">$0.00</div>
                </div>
                <div class="cbs">
                    <button class="cbtn" onclick="resizeBP(1)">▲</button>
                    <button class="cbtn" onclick="resizeBP(-1)">▼</button>
                </div>
            </div>
            <div id="pos-panel" style="flex:1;overflow-y:auto;display:flex;flex-direction:column">
                <div class="th">
                    <div>Symbol</div>
                    <div>ID</div>
                    <div>Time</div>
                    <div>Type</div>
                    <div>Vol</div>
                    <div>Open</div>
                    <div>SL</div>
                    <div>TP</div>
                    <div>Swap</div>
                    <div>Profit</div>
                    <div>Action</div>
                </div>
                <div id="pos-rows"></div>
                <div class="nop" id="nop-msg">
                    <div class="nop-icon">📊</div>No open positions
                </div>
            </div>
            <div id="pending-panel" style="flex:1;overflow-y:auto;display:none">
                <div class="nop">
                    <div class="nop-icon">⏳</div>No pending orders
                </div>
            </div>
            <div id="history-panel" style="flex:1;overflow-y:auto;display:none">
                <div class="nop" id="history-empty">
                    <div class="nop-icon">📋</div>No trade history
                </div>
                <div id="history-rows"></div>
            </div>
        </div>

        <!-- MOBILE NAV -->
        <div id="mobile-nav">
            <button class="mnav-btn act" id="mnav-chart" onclick="mobileNav('chart',this)"><i
                    class="fa-solid fa-chart-candlestick"></i>Chart</button>
            <button class="mnav-btn" id="mnav-watch" onclick="mobileNav('watch',this)"><i
                    class="fa-solid fa-list"></i>Watch</button>
            <button class="mnav-btn" id="mnav-trade" onclick="openTradeModal()"><i class="fa-solid fa-circle-plus"
                    style="font-size:28px;color:var(--blu)"></i></button>
            <button class="mnav-btn" id="mnav-pos" onclick="mobileNav('pos',this)"><i
                    class="fa-solid fa-briefcase"></i><span id="mnav-pos-label">Positions</span></button>
            <button class="mnav-btn" id="mnav-settings" onclick="mobileNav('settings',this)"><i
                    class="fa-solid fa-sliders"></i>Tools</button>
        </div>
    </div>

    <!-- MOBILE PANELS -->
    <div id="m-watchlist" class="mobile-panel">
        <div class="m-panel-head">
            <i class="fa-solid fa-magnifying-glass" style="color:var(--t3)"></i>
            <input id="m-wl-search"
                style="flex:1;background:var(--bg3);border:1px solid var(--bdr);color:var(--t1);padding:7px 10px;border-radius:7px;font-size:13px;font-family:inherit;outline:none"
                placeholder="Search symbol…" oninput="filterMWL(this.value)">
        </div>
        <div id="m-watchlist-body"></div>
    </div>

    <div id="m-positions" class="mobile-panel">
        <div class="m-panel-head">
            <div class="m-panel-title">Positions</div>
            <span class="btab-badge" id="m-pos-count" style="font-size:11px;padding:2px 8px">0</span>
            <div style="margin-left:auto;display:flex;gap:6px">
                <button class="btn" style="font-size:11px;padding:3px 10px" onclick="mobileShowTab('pos')">Open</button>
                <button class="btn" style="font-size:11px;padding:3px 10px"
                    onclick="mobileShowTab('hist')">History</button>
            </div>
        </div>
        <div class="m-acct-strip">
            <div class="m-ai"><label>Balance</label>
                <div class="v" id="m-acct-bal">$10,000</div>
            </div>
            <div class="m-ai"><label>Equity</label>
                <div class="v" id="m-acct-eq">$10,000</div>
            </div>
            <div class="m-ai"><label>P&L</label>
                <div class="v" id="m-acct-pnl">$0.00</div>
            </div>
        </div>
        <div id="m-pos-list"></div>
        <div id="m-hist-list"
            style="flex:1;overflow-y:auto;-webkit-overflow-scrolling:touch;display:none;padding-bottom:8px"></div>
    </div>

    <div id="m-tools" class="mobile-panel" style="overflow-y:auto">
        <div class="m-panel-head">
            <div class="m-panel-title">Chart Tools</div>
        </div>
        <div style="padding:12px">
            <div style="margin-bottom:14px">
                <div
                    style="font-size:10px;color:var(--t3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px">
                    Timeframe</div>
                <div style="display:flex;gap:6px;flex-wrap:wrap">
                    <button class="btn"
                        style="flex:1;padding:8px;font-size:12px;border:1px solid var(--bdr);border-radius:6px"
                        onclick="setTF('1m',this);mobileNav('chart',document.getElementById('mnav-chart'))">1m</button>
                    <button class="btn"
                        style="flex:1;padding:8px;font-size:12px;border:1px solid var(--bdr);border-radius:6px"
                        onclick="setTF('5m',this);mobileNav('chart',document.getElementById('mnav-chart'))">5m</button>
                    <button class="btn"
                        style="flex:1;padding:8px;font-size:12px;border:1px solid var(--bdr);border-radius:6px"
                        onclick="setTF('15m',this);mobileNav('chart',document.getElementById('mnav-chart'))">15m</button>
                    <button class="btn"
                        style="flex:1;padding:8px;font-size:12px;border:1px solid var(--bdr);border-radius:6px;background:var(--blul);color:var(--blu);border-color:var(--blu)"
                        onclick="setTF('1H',this);mobileNav('chart',document.getElementById('mnav-chart'))">1H</button>
                    <button class="btn"
                        style="flex:1;padding:8px;font-size:12px;border:1px solid var(--bdr);border-radius:6px"
                        onclick="setTF('4H',this);mobileNav('chart',document.getElementById('mnav-chart'))">4H</button>
                    <button class="btn"
                        style="flex:1;padding:8px;font-size:12px;border:1px solid var(--bdr);border-radius:6px"
                        onclick="setTF('1D',this);mobileNav('chart',document.getElementById('mnav-chart'))">1D</button>
                </div>
            </div>
            <div style="margin-bottom:14px">
                <div
                    style="font-size:10px;color:var(--t3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px">
                    Chart Type</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px">
                    <button class="btn"
                        style="padding:10px;font-size:12px;border:1px solid var(--bdr);border-radius:6px"
                        onclick="setChartType('candle',this);mobileNav('chart',document.getElementById('mnav-chart'))">🕯
                        Candles</button>
                    <button class="btn"
                        style="padding:10px;font-size:12px;border:1px solid var(--bdr);border-radius:6px"
                        onclick="setChartType('bar',this);mobileNav('chart',document.getElementById('mnav-chart'))">📊
                        Bars</button>
                    <button class="btn"
                        style="padding:10px;font-size:12px;border:1px solid var(--bdr);border-radius:6px"
                        onclick="setChartType('line',this);mobileNav('chart',document.getElementById('mnav-chart'))">📈
                        Line</button>
                    <button class="btn"
                        style="padding:10px;font-size:12px;border:1px solid var(--bdr);border-radius:6px"
                        onclick="setChartType('area',this);mobileNav('chart',document.getElementById('mnav-chart'))">🌊
                        Area</button>
                </div>
            </div>
            <div style="margin-bottom:14px">
                <div
                    style="font-size:10px;color:var(--t3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px">
                    Indicators</div>
                <div style="display:flex;gap:6px">
                    <button class="ind-badge" id="m-ind-ma" style="flex:1;padding:10px;font-size:12px;border-radius:6px"
                        onclick="toggleIndicator('ma');document.getElementById('m-ind-ma').classList.toggle('act',indicators.ma)">MA
                        (20)</button>
                    <button class="ind-badge" id="m-ind-bb" style="flex:1;padding:10px;font-size:12px;border-radius:6px"
                        onclick="toggleIndicator('bb');document.getElementById('m-ind-bb').classList.toggle('act',indicators.bb)">BB
                        (20)</button>
                </div>
            </div>
            <div style="margin-bottom:14px">
                <div
                    style="font-size:10px;color:var(--t3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px">
                    Layout</div>
                <div style="display:flex;gap:6px">
                    <button class="vbtn act"
                        style="flex:1;padding:9px;font-size:12px;border:1px solid var(--bdr);border-radius:6px"
                        onclick="setView('single',this);mobileNav('chart',document.getElementById('mnav-chart'))">Single</button>
                    <button class="vbtn"
                        style="flex:1;padding:9px;font-size:12px;border:1px solid var(--bdr);border-radius:6px"
                        onclick="setView('2x2',this);mobileNav('chart',document.getElementById('mnav-chart'))">2×2</button>
                    <button class="vbtn"
                        style="flex:1;padding:9px;font-size:12px;border:1px solid var(--bdr);border-radius:6px"
                        onclick="setView('1x3',this);mobileNav('chart',document.getElementById('mnav-chart'))">1×3</button>
                </div>
            </div>
            <div
                style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-top:1px solid var(--bdr)">
                <span style="font-size:12px;color:var(--t2)">Dark / Light Theme</span>
                <button class="theme-btn" onclick="toggleTheme()"><span id="m-theme-icon"><i
                            class="fa-solid fa-sun"></i></span></button>
            </div>
        </div>
    </div>

    <!-- TRADE MODAL -->
    <div id="modal-overlay">
        <div class="modal">
            <div class="modal-drag-handle"></div>
            <h3 id="modal-title">New Order · EUR/USD</h3>
            <div class="modal-row">
                <label>Symbol</label>
                <select id="m-sym" onchange="modalUpdatePrices()"></select>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                <div class="modal-row"><label>Bid</label><input id="m-bid" readonly style="color:var(--red)"></div>
                <div class="modal-row"><label>Ask</label><input id="m-ask" readonly style="color:var(--grn)"></div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                <div class="modal-row"><label>Volume (Lots)</label><input type="number" id="m-vol" value="0.1"
                        min="0.01" step="0.01"></div>
                <div class="modal-row">
                    <label>Leverage</label>
                    <select id="m-lev">
                        <option value="1">1:1</option>
                        <option value="10">1:10</option>
                        <option value="50" selected>1:50</option>
                        <option value="100">1:100</option>
                        <option value="200">1:200</option>
                    </select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                <div class="modal-row"><label>Stop Loss</label><input type="number" id="m-sl" placeholder="0.00000"
                        step="0.00001"></div>
                <div class="modal-row"><label>Take Profit</label><input type="number" id="m-tp" placeholder="0.00000"
                        step="0.00001"></div>
            </div>
            <div class="modal-btns">
                <button class="mbtn sell" onclick="executeTrade('sell')">▼ SELL</button>
                <button class="mbtn buy" onclick="executeTrade('buy')">▲ BUY</button>
                <button class="mbtn cancel" onclick="closeModal()">✕</button>
            </div>
        </div>
    </div>

    <div id="toast-container"></div>

    <script>
        // ═══════════════════════════════════════════════
        //  DATA DEFINITIONS
        // ═══════════════════════════════════════════════
        const PAIRS = [
            { s: 'EURUSD', sp: 21, d: 5, vol: 0.50, cat: 'FX Major' }, { s: 'GBPUSD', sp: 28, d: 5, vol: 0.60, cat: 'FX Major' },
            { s: 'USDJPY', sp: 31, d: 3, vol: 3.00, cat: 'FX Major' }, { s: 'USDCHF', sp: 23, d: 5, vol: 0.50, cat: 'FX Major' },
            { s: 'USDCAD', sp: 24, d: 5, vol: 0.50, cat: 'FX Major' }, { s: 'AUDUSD', sp: 26, d: 5, vol: 0.40, cat: 'FX Major' },
            { s: 'NZDUSD', sp: 30, d: 5, vol: 0.35, cat: 'FX Major' }, { s: 'EURGBP', sp: 24, d: 5, vol: 0.40, cat: 'FX Cross' },
            { s: 'EURJPY', sp: 32, d: 3, vol: 3.00, cat: 'FX Cross' }, { s: 'GBPJPY', sp: 35, d: 3, vol: 3.50, cat: 'FX Cross' },
            { s: 'AUDCAD', sp: 26, d: 5, vol: 0.50, cat: 'FX Cross' }, { s: 'AUDCHF', sp: 25, d: 5, vol: 0.40, cat: 'FX Cross' },
            { s: 'CADJPY', sp: 32, d: 3, vol: 3.00, cat: 'FX Cross' }, { s: 'GBPNZD', sp: 30, d: 5, vol: 1.20, cat: 'FX Cross' },
            { s: 'XAUUSD', sp: 40, d: 2, vol: 1.50, cat: 'Metals' }, { s: 'XAGUSD', sp: 60, d: 2, vol: 0.15, cat: 'Metals' },
        ];
        const PIPS = { EURUSD: 0.00001, GBPUSD: 0.00001, USDJPY: 0.001, USDCHF: 0.00001, USDCAD: 0.00001, AUDUSD: 0.00001, NZDUSD: 0.00001, EURGBP: 0.00001, EURJPY: 0.001, GBPJPY: 0.001, AUDCAD: 0.00001, AUDCHF: 0.00001, CADJPY: 0.001, GBPNZD: 0.00001, XAUUSD: 0.01, XAGUSD: 0.01 };
        const SPREADS = { EURUSD: 21, GBPUSD: 28, USDJPY: 31, USDCHF: 23, USDCAD: 24, AUDUSD: 26, NZDUSD: 30, EURGBP: 24, EURJPY: 32, GBPJPY: 35, AUDCAD: 26, AUDCHF: 25, CADJPY: 32, GBPNZD: 30, XAUUSD: 40, XAGUSD: 60 };

        // seed prices — will be overwritten by live fetch
        let P = {
            EURUSD: { b: 1.08500, p: 1.08450 }, GBPUSD: { b: 1.27200, p: 1.27100 }, USDJPY: { b: 149.500, p: 149.400 },
            USDCHF: { b: 0.90500, p: 0.90450 }, USDCAD: { b: 1.36500, p: 1.36450 }, AUDUSD: { b: 0.65500, p: 0.65450 },
            NZDUSD: { b: 0.60500, p: 0.60450 }, EURGBP: { b: 0.85300, p: 0.85250 }, EURJPY: { b: 162.100, p: 162.000 },
            GBPJPY: { b: 190.200, p: 190.100 }, AUDCAD: { b: 0.89800, p: 0.89750 }, AUDCHF: { b: 0.59300, p: 0.59250 },
            CADJPY: { b: 109.500, p: 109.450 }, GBPNZD: { b: 2.10200, p: 2.10100 }, XAUUSD: { b: 2350.00, p: 2348.00 }, XAGUSD: { b: 28.50, p: 28.40 }
        };

        // ═══════════════════════════════════════════════
        //  TRADINGVIEW CONFIG
        // ═══════════════════════════════════════════════
        const TV_SYMBOLS = {
            EURUSD: 'FX:EURUSD', GBPUSD: 'FX:GBPUSD', USDJPY: 'FX:USDJPY', USDCHF: 'FX:USDCHF',
            USDCAD: 'FX:USDCAD', AUDUSD: 'FX:AUDUSD', NZDUSD: 'FX:NZDUSD', EURGBP: 'FX:EURGBP',
            EURJPY: 'FX:EURJPY', GBPJPY: 'FX:GBPJPY', AUDCAD: 'FX:AUDCAD', AUDCHF: 'FX:AUDCHF',
            CADJPY: 'FX:CADJPY', GBPNZD: 'FX:GBPNZD', XAUUSD: 'TVC:GOLD', XAGUSD: 'TVC:SILVER'
        };
        const TV_TF = { '1m': '1', '5m': '5', '15m': '15', '1H': '60', '4H': '240', '1D': 'D' };
        const TV_STYLE = { candle: '1', bar: '0', line: '2', area: '3' };
        const TV_STUDIES = { ma: ['MASimple@tv-basicstudies'], bb: ['BB@tv-basicstudies'], vol: ['Volume@tv-basicstudies'] };
        const MULTI_SYMS = {
            '2x2': ['EURUSD', 'GBPUSD', 'USDJPY', 'XAUUSD'],
            '1x3': ['EURUSD', 'USDJPY', 'XAUUSD']
        };

        // ═══════════════════════════════════════════════
        //  STATE
        // ═══════════════════════════════════════════════
        let wlFilter = '', selectedSym = 'EURUSD', chartType = 'candle', currentTF = '1H';
        let indicators = { ma: false, bb: false, vol: false };
        let positions = [], tradeCounter = 1000, historyTrades = [];
        let balance = 10000, viewMode = 'single', mobileTab = 'pos';
        let priceHistory = {};  // for sparklines / % change tracking
        let liveDataSource = 'simulation'; // 'yahoo'|'frankfurter'|'simulation'

        function askPrice(s) { return P[s].b + PIPS[s] * SPREADS[s] }

        // ═══════════════════════════════════════════════
        //  TRADINGVIEW CHART
        // ═══════════════════════════════════════════════
        function getActiveStudies() {
            const s = [];
            if (indicators.ma) s.push(...TV_STUDIES.ma);
            if (indicators.bb) s.push(...TV_STUDIES.bb);
            if (indicators.vol) s.push(...TV_STUDIES.vol);
            return s;
        }

        function initChart() {
            const wrap = document.getElementById('chart-main');
            if (!wrap) return;
            if (typeof TradingView === 'undefined') {
                document.getElementById('candle-timer').textContent = 'Loading TV…';
                setTimeout(initChart, 800); return;
            }
            wrap.innerHTML = '';
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            new TradingView.widget({
                autosize: true,
                symbol: TV_SYMBOLS[selectedSym] || 'FX:EURUSD',
                interval: TV_TF[currentTF] || '60',
                timezone: 'Etc/UTC',
                theme: isDark ? 'dark' : 'light',
                style: TV_STYLE[chartType] || '1',
                locale: 'en',
                toolbar_bg: isDark ? '#131720' : '#f0f2f8',
                enable_publishing: false,
                withdateranges: true,
                hide_side_toolbar: false,
                allow_symbol_change: false,
                container_id: 'chart-main',
                studies: getActiveStudies(),
                show_popup_button: false,
                hide_top_toolbar: false,
                save_image: true,
                backgroundColor: isDark ? 'rgba(13,15,20,1)' : 'rgba(255,255,255,1)',
                gridColor: isDark ? 'rgba(42,48,80,0.5)' : 'rgba(200,207,230,0.5)',
            });
            document.getElementById('candle-timer').textContent = 'TradingView LIVE';
            document.getElementById('live-sym').textContent = 'LIVE · ' + selectedSym.slice(0, 3) + '/' + selectedSym.slice(3);
        }

        function rebuildChart() {
            if (viewMode === 'single') initChart();
            else buildMultiChart(viewMode);
        }

        function buildMultiChart(cnt) {
            const grid = document.getElementById('multi-grid');
            grid.innerHTML = '';
            const syms = MULTI_SYMS[cnt] || MULTI_SYMS['2x2'];
            const cols = cnt === '1x3' ? 3 : 2, rows = cnt === '1x3' ? 1 : 2;
            grid.style.gridTemplateColumns = `repeat(${cols},1fr)`;
            grid.style.gridTemplateRows = `repeat(${rows},1fr)`;
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            syms.forEach((sym, i) => {
                const cell = document.createElement('div');
                cell.className = 'chart-cell';
                const cid = 'tv_mc_' + sym + '_' + Date.now();
                cell.innerHTML = `<div id="${cid}" style="width:100%;height:100%"></div>`;
                grid.appendChild(cell);
                setTimeout(() => {
                    if (typeof TradingView === 'undefined') return;
                    new TradingView.widget({
                        autosize: true,
                        symbol: TV_SYMBOLS[sym] || 'FX:EURUSD',
                        interval: TV_TF[currentTF] || '60',
                        timezone: 'Etc/UTC',
                        theme: isDark ? 'dark' : 'light',
                        style: TV_STYLE[chartType] || '1',
                        locale: 'en',
                        enable_publishing: false,
                        hide_side_toolbar: true,
                        hide_top_toolbar: true,
                        allow_symbol_change: false,
                        container_id: cid,
                        backgroundColor: isDark ? 'rgba(13,15,20,1)' : 'rgba(255,255,255,1)',
                    });
                }, i * 120);
            });
        }

        // ═══════════════════════════════════════════════
        //  LIVE PRICE FEED  (Yahoo Finance → Frankfurter → simulation)
        // ═══════════════════════════════════════════════
        const YAHOO_MAP = {
            EURUSD: 'EURUSD=X', GBPUSD: 'GBPUSD=X', USDJPY: 'USDJPY=X', USDCHF: 'USDCHF=X',
            USDCAD: 'USDCAD=X', AUDUSD: 'AUDUSD=X', NZDUSD: 'NZDUSD=X', EURGBP: 'EURGBP=X',
            EURJPY: 'EURJPY=X', GBPJPY: 'GBPJPY=X', AUDCAD: 'AUDCAD=X', AUDCHF: 'AUDCHF=X',
            CADJPY: 'CADJPY=X', GBPNZD: 'GBPNZD=X', XAUUSD: 'GC=F', XAGUSD: 'SI=F'
        };

        async function fetchYahooRates() {
            try {
                const syms = Object.values(YAHOO_MAP).join(',');
                const res = await fetch(`https://query1.finance.yahoo.com/v7/finance/quote?symbols=${syms}&formatted=false&lang=en&region=US`, { cache: 'no-store' });
                if (!res.ok) throw new Error('yahoo err');
                const data = await res.json();
                const quotes = data?.quoteResponse?.result || [];
                if (!quotes.length) throw new Error('no quotes');
                quotes.forEach(q => {
                    const pair = Object.keys(YAHOO_MAP).find(k => YAHOO_MAP[k] === q.symbol);
                    if (pair && q.regularMarketPrice) {
                        P[pair].p = P[pair].b;
                        P[pair].b = parseFloat(q.regularMarketPrice) || P[pair].b;
                        if (q.regularMarketOpen) P[pair].o = q.regularMarketOpen;
                        if (q.regularMarketDayHigh) P[pair].h = q.regularMarketDayHigh;
                        if (q.regularMarketDayLow) P[pair].l = q.regularMarketDayLow;
                    }
                });
                liveDataSource = 'yahoo';
                setDataBadge('● Yahoo Finance LIVE', '#00d4aa');
                afterPriceUpdate();
                return true;
            } catch (e) { return false; }
        }

        async function fetchFrankfurterRates() {
            try {
                const res = await fetch('https://api.frankfurter.app/latest?from=USD&to=EUR,GBP,JPY,CAD,CHF,NZD,AUD', { cache: 'no-store' });
                if (!res.ok) throw new Error();
                const data = await res.json();
                const { EUR: eu, GBP: gb, JPY: jp, CAD: ca, CHF: ch, NZD: nz, AUD: au } = data.rates;
                const set = (s, v) => { P[s].p = P[s].b; P[s].b = parseFloat(parseFloat(v).toFixed(8)) };
                set('EURUSD', (1 / eu).toFixed(5)); set('GBPUSD', (1 / gb).toFixed(5));
                set('USDJPY', jp.toFixed(3)); set('USDCHF', ch.toFixed(5));
                set('USDCAD', ca.toFixed(5)); set('AUDUSD', (1 / au).toFixed(5));
                set('NZDUSD', (1 / nz).toFixed(5)); set('EURGBP', (gb / eu).toFixed(5));
                set('EURJPY', (jp / eu).toFixed(3)); set('GBPJPY', (jp / gb).toFixed(3));
                set('AUDCAD', (ca / au).toFixed(5)); set('AUDCHF', (ch / au).toFixed(5));
                set('CADJPY', (jp / ca).toFixed(3)); set('GBPNZD', (nz / gb).toFixed(5));
                liveDataSource = 'frankfurter';
                setDataBadge('● Frankfurter LIVE', '#4f7cff');
                afterPriceUpdate();
                return true;
            } catch (e) { return false; }
        }

        function setDataBadge(txt, color) {
            const el = document.getElementById('data-src');
            if (el) { el.textContent = txt; el.style.color = color; el.style.borderColor = color; el.style.background = color + '22'; }
            const wl = document.getElementById('wl-src');
            if (wl) { wl.textContent = txt.split(' ')[1] || 'LIVE'; wl.style.color = color; }
        }

        async function fetchLiveRates() {
            const ok = await fetchYahooRates();
            if (!ok) await fetchFrankfurterRates();
        }

        function simulateTick() {
            PAIRS.forEach(pair => {
                const { s, vol } = pair; const pip = PIPS[s];
                const delta = (Math.random() - 0.499) * pip * vol * (0.5 + Math.random());
                P[s].b = Math.max(P[s].b + delta, pip * 50);
            });
            afterPriceUpdate();
        }

        function afterPriceUpdate() {
            renderWL(); renderMWL(); updateTopbarPrices(); updateHeader();
        }

        // ═══════════════════════════════════════════════
        //  WATCHLIST
        // ═══════════════════════════════════════════════
        function filterWL(v) { wlFilter = v.toLowerCase(); renderWL() }
        function filterMWL(v) { wlFilter = v.toLowerCase(); renderMWL() }

        function renderWL() {
            const body = document.getElementById('wlb');
            if (!body) return;
            const filtered = PAIRS.filter(p => wlFilter === '' || p.s.toLowerCase().includes(wlFilter) || p.cat.toLowerCase().includes(wlFilter));
            body.innerHTML = filtered.map(pair => {
                const { s, d } = pair; const bid = P[s].b, a = askPrice(s);
                const prev = P[s].p || bid;
                const chg = bid - prev, pct = (chg / prev) * 100;
                const dir = Math.abs(pct) < 0.001 ? 'flat' : pct >= 0 ? 'up' : 'dn';
                const sign = pct >= 0 ? '+' : '';
                return `<div class="wi${s === selectedSym ? ' sel' : ''}" onclick="selectPair('${s}')">
<div class="wr1"><div class="wsym">${s}<span class="wsp">${SPREADS[s]}</span></div><div class="wchg ${dir}"><div class="wpct">${sign}${pct.toFixed(2)}%</div></div></div>
<div class="wr3"><div class="wbid">${bid.toFixed(d)}</div><div class="wask">${a.toFixed(d)}</div></div>
<div class="wchg-abs">${sign}${Math.abs(chg).toFixed(d < 3 ? 3 : 5)}</div></div>`;
            }).join('');
        }

        function renderMWL() {
            const body = document.getElementById('m-watchlist-body');
            if (!body) return;
            const filtered = PAIRS.filter(p => wlFilter === '' || p.s.toLowerCase().includes(wlFilter) || p.cat.toLowerCase().includes(wlFilter));
            body.innerHTML = filtered.map(pair => {
                const { s, d, cat } = pair; const bid = P[s].b, a = askPrice(s);
                const prev = P[s].p || bid;
                const chg = bid - prev, pct = (chg / prev) * 100;
                const dir = Math.abs(pct) < 0.001 ? 'flat' : pct >= 0 ? 'up' : 'dn';
                const sign = pct >= 0 ? '+' : '';
                return `<div class="m-wi${s === selectedSym ? ' sel' : ''}" onclick="selectPair('${s}');mobileNav('chart',document.getElementById('mnav-chart'))">
<div class="m-wi-sym">${s}</div>
<div class="m-wi-cat">${cat} · Spread: ${SPREADS[s]}</div>
<div class="m-wi-prices"><span class="m-wi-bid">${bid.toFixed(d)}</span><span class="m-wi-ask">${a.toFixed(d)}</span></div>
<div class="m-wi-right">
<span class="m-wi-chg ${dir}">${sign}${pct.toFixed(2)}%</span>
<span style="font-size:10px;color:var(--t3)">${sign}${Math.abs(chg).toFixed(d < 3 ? 3 : 5)}</span>
</div></div>`;
            }).join('');
        }

        function selectPair(sym) {
            selectedSym = sym;
            document.getElementById('sym-select').value = sym;
            document.getElementById('sym-label').textContent = sym.slice(0, 3) + '/' + sym.slice(3);
            document.getElementById('live-sym').textContent = 'LIVE · ' + sym.slice(0, 3) + '/' + sym.slice(3);
            renderWL(); renderMWL(); updateTopbarPrices(); updateHeader();
            if (viewMode === 'single') initChart();
        }
        function selectPairFromTop(sym) { selectPair(sym) }

        // ═══════════════════════════════════════════════
        //  HEADER
        // ═══════════════════════════════════════════════
        function updateHeader() {
            const sym = selectedSym; const d = PAIRS.find(p => p.s === sym); const dec = d ? d.d : 5;
            const price = P[sym].b, prev = P[sym].p || price;
            const chg = price - prev, pct = (chg / prev) * 100; const sign = chg >= 0 ? '+' : '';
            const el = document.getElementById('pchg');
            if (el) { el.textContent = `${sign}${chg.toFixed(dec < 3 ? 3 : 5)} (${sign}${pct.toFixed(2)}%)`; el.className = 'pchg ' + (chg >= 0 ? 'up' : 'dn') }
            if (P[sym].o) document.getElementById('oo').textContent = P[sym].o.toFixed(dec);
            if (P[sym].h) document.getElementById('oh').textContent = P[sym].h.toFixed(dec);
            if (P[sym].l) document.getElementById('ol').textContent = P[sym].l.toFixed(dec);
            document.getElementById('oc').textContent = price.toFixed(dec);
        }

        function updateTopbarPrices() {
            const s = selectedSym; const d = PAIRS.find(p => p.s === s); const dec = d ? d.d : 5;
            const bid = P[s].b, a = askPrice(s);
            const e = (id, v) => { const el = document.getElementById(id); if (el) el.textContent = v };
            e('tb-bid', bid.toFixed(dec)); e('tb-ask', a.toFixed(dec)); e('tb-spread', SPREADS[s] + ' pts');
        }

        // ═══════════════════════════════════════════════
        //  VIEW / TF / CHART TYPE
        // ═══════════════════════════════════════════════
        function setView(v, btn) {
            viewMode = v;
            document.querySelectorAll('.vbtn').forEach(b => b.classList.remove('act'));
            if (btn) btn.classList.add('act');
            const single = document.getElementById('chart-main');
            const mgrid = document.getElementById('multi-grid');
            if (v === 'single') { single.style.display = 'block'; mgrid.style.display = 'none'; initChart(); }
            else { single.style.display = 'none'; mgrid.style.display = 'grid'; buildMultiChart(v); }
        }

        function setChartType(type, btn) {
            chartType = type;
            document.querySelectorAll('.ct-btn').forEach(b => b.classList.remove('act'));
            if (btn) btn.classList.add('act');
            rebuildChart();
        }

        function setTF(tf, btn) {
            currentTF = tf;
            document.querySelectorAll('.tf-grp .btn').forEach(b => b.classList.remove('act'));
            if (btn) btn.classList.add('act');
            rebuildChart();
        }

        function toggleIndicator(ind) {
            indicators[ind] = !indicators[ind];
            const btn = document.getElementById('ind-' + ind);
            if (btn) btn.classList.toggle('act', indicators[ind]);
            if (viewMode === 'single') initChart(); // rebuild with new studies
        }

        // ═══════════════════════════════════════════════
        //  TRADING
        // ═══════════════════════════════════════════════
        function openTradeModal() {
            const sel = document.getElementById('m-sym');
            sel.innerHTML = PAIRS.map(p => `<option value="${p.s}"${p.s === selectedSym ? ' selected' : ''}>${p.s}</option>`).join('');
            modalUpdatePrices();
            document.getElementById('modal-title').textContent = `New Order · ${selectedSym}`;
            document.getElementById('modal-overlay').classList.add('open');
        }
        function closeModal() { document.getElementById('modal-overlay').classList.remove('open') }
        document.getElementById('modal-overlay').addEventListener('click', function (e) { if (e.target === this) closeModal() });

        function modalUpdatePrices() {
            const sym = document.getElementById('m-sym').value;
            const d = PAIRS.find(p => p.s === sym); const dec = d ? d.d : 5;
            document.getElementById('m-bid').value = P[sym].b.toFixed(dec);
            document.getElementById('m-ask').value = askPrice(sym).toFixed(dec);
            document.getElementById('modal-title').textContent = `New Order · ${sym}`;
        }

        function executeTrade(side) {
            const sym = document.getElementById('m-sym').value;
            const vol = parseFloat(document.getElementById('m-vol').value) || 0.1;
            const lev = parseInt(document.getElementById('m-lev').value) || 50;
            const slInp = parseFloat(document.getElementById('m-sl').value) || 0;
            const tpInp = parseFloat(document.getElementById('m-tp').value) || 0;
            const d = PAIRS.find(p => p.s === sym); const dec = d ? d.d : 5;
            const openPrice = side === 'buy' ? askPrice(sym) : P[sym].b;
            const marginReq = (openPrice * vol * 100000) / lev;
            if (marginReq > balance) { showToast('Insufficient margin!', 'error'); return }
            const pos = { id: tradeCounter++, sym, side, vol, openPrice, sl: slInp, tp: tpInp, time: new Date().toLocaleTimeString(), margin: marginReq, swap: 0 };
            positions.push(pos); balance -= marginReq; closeModal();
            showToast(`✅ ${side.toUpperCase()} ${vol} lots ${sym} @ ${openPrice.toFixed(dec)}`, 'success');
            renderPositions(); renderMPositions(); updateAccountStats();
            document.getElementById('pos-count').textContent = positions.length;
            document.getElementById('m-pos-count').textContent = positions.length;
        }

        function closePosition(id) {
            const idx = positions.findIndex(p => p.id === id); if (idx < 0) return;
            const pos = positions[idx]; const d = PAIRS.find(p => p.s === pos.sym); const dec = d ? d.d : 5;
            const closePrice = pos.side === 'buy' ? P[pos.sym].b : askPrice(pos.sym);
            const diff = pos.side === 'buy' ? closePrice - pos.openPrice : pos.openPrice - closePrice;
            const profit = diff * (1 / PIPS[pos.sym] || 100000) * pos.vol * 0.1;
            balance += pos.margin + profit;
            historyTrades.push({ ...pos, closePrice, profit, closedAt: new Date().toLocaleTimeString() });
            positions.splice(idx, 1);
            const sign = profit >= 0 ? '+' : '';
            showToast(`${profit >= 0 ? '✅' : '❌'} Closed #${id}: ${sign}$${Math.abs(profit).toFixed(2)}`, (profit >= 0 ? 'success' : 'error'));
            renderPositions(); renderMPositions(); renderHistory(); renderMHistory();
            updateAccountStats();
            document.getElementById('hist-count').textContent = historyTrades.length;
            document.getElementById('pos-count').textContent = positions.length;
            document.getElementById('m-pos-count').textContent = positions.length;
        }

        function calcProfit(pos) {
            const closePrice = pos.side === 'buy' ? P[pos.sym].b : askPrice(pos.sym);
            const diff = pos.side === 'buy' ? closePrice - pos.openPrice : pos.openPrice - closePrice;
            return diff * (1 / PIPS[pos.sym] || 100000) * pos.vol * 0.1;
        }

        function renderPositions() {
            const rows = document.getElementById('pos-rows'); const nop = document.getElementById('nop-msg');
            document.getElementById('pos-count').textContent = positions.length;
            if (!positions.length) { rows.innerHTML = ''; nop.style.display = 'flex'; return }
            nop.style.display = 'none';
            rows.innerHTML = positions.map(pos => {
                const profit = calcProfit(pos); const sign = profit >= 0 ? '+' : ''; const cls = profit >= 0 ? 'pos' : 'neg';
                const d = PAIRS.find(p => p.s === pos.sym); const dec = d ? d.d : 5;
                return `<div class="pos-row">
<div style="font-weight:600">${pos.sym}</div><div style="color:var(--t3)">#${pos.id}</div>
<div style="color:var(--t3);font-size:10px">${pos.time}</div>
<div style="color:${pos.side === 'buy' ? 'var(--grn)' : 'var(--red)'};font-weight:600;text-transform:uppercase">${pos.side}</div>
<div>${pos.vol}</div><div>${pos.openPrice.toFixed(dec)}</div>
<div style="color:var(--red)">${pos.sl ? pos.sl.toFixed(dec) : '—'}</div>
<div style="color:var(--grn)">${pos.tp ? pos.tp.toFixed(dec) : '—'}</div>
<div style="color:var(--t3)">$${pos.swap.toFixed(2)}</div>
<div class="pos-profit ${cls}">${sign}$${profit.toFixed(2)}</div>
<div><button class="close-pos" onclick="closePosition(${pos.id})">Close</button></div></div>`;
            }).join('');
        }

        function renderMPositions() {
            const list = document.getElementById('m-pos-list'); if (!list) return;
            document.getElementById('m-pos-count').textContent = positions.length;
            if (!positions.length) {
                list.innerHTML = `<div class="m-nop"><div class="m-nop-icon">📊</div>No open positions<br><span style="font-size:11px;color:var(--t3)">Tap + to place a trade</span></div>`;
                return;
            }
            list.innerHTML = positions.map(pos => {
                const profit = calcProfit(pos); const sign = profit >= 0 ? '+' : ''; const cls = profit >= 0 ? 'pos' : 'neg';
                const d = PAIRS.find(p => p.s === pos.sym); const dec = d ? d.d : 5;
                return `<div class="m-pos-card">
<div class="m-pos-card-head"><span class="m-pos-sym">${pos.sym}</span><span style="color:var(--t3);font-size:11px">#${pos.id}</span><span class="m-pos-side ${pos.side}">${pos.side}</span></div>
<div class="m-pos-grid">
<div class="m-pos-field"><label>Open</label><div class="val">${pos.openPrice.toFixed(dec)}</div></div>
<div class="m-pos-field"><label>Volume</label><div class="val">${pos.vol} lot</div></div>
<div class="m-pos-field"><label>Time</label><div class="val" style="font-size:10px">${pos.time}</div></div>
<div class="m-pos-field"><label>SL</label><div class="val" style="color:var(--red)">${pos.sl ? pos.sl.toFixed(dec) : '—'}</div></div>
<div class="m-pos-field"><label>TP</label><div class="val" style="color:var(--grn)">${pos.tp ? pos.tp.toFixed(dec) : '—'}</div></div>
<div class="m-pos-field"><label>Current</label><div class="val">${P[pos.sym].b.toFixed(dec)}</div></div>
</div>
<div class="m-pos-profit ${cls}">${sign}$${profit.toFixed(2)}</div>
<button class="m-close-btn" onclick="closePosition(${pos.id})">Close Position</button>
</div>`;
            }).join('');
        }

        function renderHistory() {
            const rows = document.getElementById('history-rows'); const empty = document.getElementById('history-empty');
            if (!historyTrades.length) { rows.innerHTML = ''; empty.style.display = 'flex'; return }
            empty.style.display = 'none';
            rows.innerHTML = historyTrades.slice().reverse().map(t => {
                const sign = t.profit >= 0 ? '+' : ''; const d = PAIRS.find(p => p.s === t.sym); const dec = d ? d.d : 5;
                return `<div class="pos-row" style="opacity:.8">
<div style="font-weight:600">${t.sym}</div><div style="color:var(--t3)">#${t.id}</div>
<div style="color:var(--t3);font-size:10px">${t.closedAt}</div>
<div style="color:${t.side === 'buy' ? 'var(--grn)' : 'var(--red)'};text-transform:uppercase">${t.side}</div>
<div>${t.vol}</div><div>${t.openPrice.toFixed(dec)}</div>
<div>—</div><div>—</div><div>—</div>
<div class="pos-profit ${t.profit >= 0 ? 'pos' : 'neg'}">${sign}$${t.profit.toFixed(2)}</div>
<div style="color:var(--t3);font-size:10px">${t.closePrice.toFixed(dec)}</div></div>`;
            }).join('');
        }

        function renderMHistory() {
            const list = document.getElementById('m-hist-list'); if (!list) return;
            if (!historyTrades.length) { list.innerHTML = `<div class="m-nop"><div class="m-nop-icon">📋</div>No trade history</div>`; return }
            list.innerHTML = historyTrades.slice().reverse().map(t => {
                const sign = t.profit >= 0 ? '+' : ''; const d = PAIRS.find(p => p.s === t.sym); const dec = d ? d.d : 5;
                return `<div class="m-hist-card">
<div class="m-hist-head">
<div><span style="font-size:13px;font-weight:700">${t.sym}</span> <span style="font-size:10px;color:${t.side === 'buy' ? 'var(--grn)' : 'var(--red)'};text-transform:uppercase">${t.side}</span></div>
<span class="m-hist-profit ${t.profit >= 0 ? 'pos' : 'neg'}">${sign}$${t.profit.toFixed(2)}</span>
</div>
<div class="m-hist-meta">#${t.id} · ${t.vol} lot · ${t.openPrice.toFixed(dec)} → ${t.closePrice.toFixed(dec)} · ${t.closedAt}</div>
</div>`;
            }).join('');
        }

        function updatePnL() {
            const totalPnL = positions.reduce((s, p) => s + calcProfit(p), 0);
            const usedMargin = positions.reduce((s, p) => s + p.margin, 0);
            const equity = balance + totalPnL + usedMargin;
            const freeMargin = equity - usedMargin;
            const marginLvl = usedMargin > 0 ? ((equity / usedMargin) * 100).toFixed(2) + '%' : '—';
            const sign = totalPnL >= 0 ? '+' : '';
            const e = (id, v, cls) => { const el = document.getElementById(id); if (!el) return; el.textContent = v; if (cls) el.className = 'v ' + cls };
            e('acct-bal', '$' + balance.toFixed(2)); e('acct-eq', '$' + equity.toFixed(2));
            e('acct-margin', '$' + usedMargin.toFixed(2)); e('acct-free', '$' + freeMargin.toFixed(2));
            e('acct-lvl', marginLvl); e('acct-pnl', sign + '$' + Math.abs(totalPnL).toFixed(2), (totalPnL >= 0 ? 'gain' : 'loss'));
            e('m-acct-bal', '$' + balance.toFixed(0)); e('m-acct-eq', '$' + equity.toFixed(0));
            e('m-acct-pnl', sign + '$' + Math.abs(totalPnL).toFixed(2), (totalPnL >= 0 ? 'gain' : 'loss'));
            renderPositions();
            if (document.getElementById('m-positions').classList.contains('open') && mobileTab === 'pos') renderMPositions();
            // auto SL/TP
            [...positions].forEach(pos => {
                const curr = P[pos.sym].b;
                if (pos.tp && pos.side === 'buy' && curr >= pos.tp) closePosition(pos.id);
                if (pos.sl && pos.side === 'buy' && curr <= pos.sl) closePosition(pos.id);
                if (pos.tp && pos.side === 'sell' && curr <= pos.tp) closePosition(pos.id);
                if (pos.sl && pos.side === 'sell' && curr >= pos.sl) closePosition(pos.id);
            });
        }
        function updateAccountStats() { updatePnL() }

        // ═══════════════════════════════════════════════
        //  THEME
        // ═══════════════════════════════════════════════
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.getAttribute('data-theme') === 'dark';
            html.setAttribute('data-theme', isDark ? 'light' : 'dark');
            const icon = isDark ? '<i class="fa-solid fa-moon"></i>' : '<i class="fa-solid fa-sun"></i>';
            document.getElementById('theme-icon').innerHTML = icon;
            const mti = document.getElementById('m-theme-icon'); if (mti) mti.innerHTML = icon;
            rebuildChart();
        }

        // ═══════════════════════════════════════════════
        //  MOBILE
        // ═══════════════════════════════════════════════
        function mobileNav(section, btn) {
            document.querySelectorAll('.mnav-btn').forEach(b => b.classList.remove('act'));
            if (btn) btn.classList.add('act');
            document.querySelectorAll('.mobile-panel').forEach(p => p.classList.remove('open'));
            if (section === 'watch') { document.getElementById('m-watchlist').classList.add('open'); renderMWL(); }
            else if (section === 'pos') { document.getElementById('m-positions').classList.add('open'); renderMPositions(); }
            else if (section === 'settings') { document.getElementById('m-tools').classList.add('open'); }
        }
        function mobileShowTab(tab) {
            mobileTab = tab;
            document.getElementById('m-pos-list').style.display = tab === 'pos' ? 'block' : 'none';
            document.getElementById('m-hist-list').style.display = tab === 'hist' ? 'block' : 'none';
            if (tab === 'pos') renderMPositions(); else renderMHistory();
        }

        // ═══════════════════════════════════════════════
        //  MISC
        // ═══════════════════════════════════════════════
        function switchTab(btn, panelId) {
            document.querySelectorAll('.btab').forEach(b => b.classList.remove('act')); btn.classList.add('act');
            ['pos-panel', 'pending-panel', 'history-panel'].forEach(id => { const el = document.getElementById(id); if (el) el.style.display = id === panelId ? 'flex' : 'none' });
        }
        function toggleFS() { if (!document.fullscreenElement) document.documentElement.requestFullscreen().catch(() => { }); else document.exitFullscreen().catch(() => { }) }
        function resizeBP(dir) { const bp = document.getElementById('bp'); const cur = parseInt(bp.style.height) || 180; bp.style.height = Math.max(100, Math.min(360, cur + dir * 60)) + 'px' }
        function showToast(msg, type = 'info') {
            const c = document.getElementById('toast-container'); const t = document.createElement('div');
            t.className = `toast ${type}`; t.textContent = msg; c.appendChild(t); setTimeout(() => t.remove(), 3500);
        }
        function updateClock() {
            const now = new Date(); const pad = n => String(n).padStart(2, '0');
            const el = document.getElementById('clk'); if (el) el.textContent = `${pad(now.getUTCHours())}:${pad(now.getUTCMinutes())}:${pad(now.getUTCSeconds())} UTC`;
        }

        // keyboard shortcuts
        document.addEventListener('keydown', e => {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT') return;
            if (e.key === 't' || e.key === 'T') openTradeModal();
            if (e.key === 'Escape') closeModal();
            if (e.key === 'd' || e.key === 'D') toggleTheme();
            if (e.key === 'f' || e.key === 'F') toggleFS();
        });

        // populate selects
        function populateSelects() {
            const sel = document.getElementById('sym-select');
            sel.innerHTML = PAIRS.map(p => `<option value="${p.s}"${p.s === selectedSym ? ' selected' : ''}>${p.s}</option>`).join('');
        }

        // ═══════════════════════════════════════════════
        //  INIT
        // ═══════════════════════════════════════════════
        window.addEventListener('load', () => {
            populateSelects();
            renderWL(); renderMWL();
            updateClock(); updateTopbarPrices(); updateHeader();
            document.getElementById('sym-label').textContent = 'EUR/USD';

            // 1. fetch live rates immediately
            fetchLiveRates();

            // 2. init TradingView chart (slight delay so tv.js fully parses)
            setTimeout(initChart, 300);

            // 3. refetch live rates every 15s (Yahoo Finance) + 30s fallback
            setInterval(fetchLiveRates, 15000);

            // 4. simulate micro-ticks between API calls for realistic watchlist movement
            setInterval(simulateTick, 800);

            // 5. PnL update
            setInterval(updatePnL, 1000);

            // 6. clock
            setInterval(updateClock, 1000);
        });
    </script>
</body>

</html>