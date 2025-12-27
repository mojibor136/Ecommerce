<div class="page-wrapper">
    <div class="page">
        <div class="page-main">
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="MobileOptimized" content="320" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
                    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
                    crossorigin="anonymous">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
                    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
                    crossorigin="anonymous" referrerpolicy="no-referrer" />
                <title>Dashboard</title>
            </head>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                }

                body {
                    font-family: Arial, Helvetica, sans-serif;
                    background-color: #f2f2f2;
                }

                .balance-container {
                    background-color: #ffffff;
                    color: crimson;
                    padding: 6px;
                    border-radius: 40px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                    width: 185px;
                    margin-left: 100px;
                    margin-top: 6px;

                }

                .balance-container:hover {
                    background-color: #ffffff;
                }

                .balance-icon {
                    display: inline-block;
                    margin-right: 5px;
                }

                .balance-amount {
                    display: none;
                }

                .mar {
                    margin-left: 15px;
                }
            </style>

            <body>
                <!-------header started-->
                <header
                    style="background: #0f51b7; width: 100%; height: 98px; border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;float: left;">
                    <div class="container">
                        <div class="profile">
                            <img src="https://cdn-icons-png.flaticon.com/512/147/147140.png"
                                style="width: 50px; float: left; margin-top: 22px; margin-left: 30px;" />
                        </div>
                        <div class="username" style="margin-top: 8px;"> <span
                                style="margin-left: 50px; color: white; font-weight: bold;"> <?php echo e(auth()->user()->username); ?></span>
                        </div>
                        <div class="balance-container" onclick="toggleBalance()">
                            <div class="mar">
                                <div class="balance-icon"><i class="fa-solid fa-bangladeshi-taka-sign"
                                        style="color: #ffffff; background: crimson; padding: 6px; border-radius: 12px;"></i>
                                </div><span class="balancebar">Tap for Balance</span>
                                <div class="balance-amount" id="balanceAmount">{{ $user->balance + 0 }}
                                    {{ $general->cur_text }}</span> </div>
                            </div>
                        </div>
                    </div>
                </header>
                <div style="background: transparent; color: black;">
                    <marquee class="mt-1">ржкрзНрж░рж┐ржпрж╝ ржЧрзНрж░рж╛рж╣ржХ ржЖржорж╛ржжрзЗрж░
                        ржУржпрж╝рзЗржмрж╕рж╛ржЗржЯрзЗ ржЖржкржирж╛ржХрзЗ рж╕рзНржмрж╛ржЧрждржо ЁЯТЦ
                        рж╕рж░рзНржмржирж┐ржорзНржи ржбрж┐ржкрзЛржЬрж┐ржЯ рзлрзжрзж ржЯрж╛ржХрж╛ ржПржмржВ
                        рж╕рж░рзНржмрзЛржЪрзНржЪ ржбрж┐ржкрзЛржЬрж┐ржЯ рзирзлрзжрзжрзж ржЯрж╛ржХрж╛
                        ЁЯТ╕ржПржЫрж╛ржбрж╝рж╛ржУ рж░рзЗржлрж╛рж░ ржХрж░рж▓рзЗржЗ ржкрж╛ржЪрзНржЫрзЗржи рззрзж%
                        ржПржХрзНрж╕ржЯрзНрж░рж╛ ржХржорж┐рж╢ржи ЁЯТ╕тЬЕ ржкрзНрж░рждрж┐ржжрж┐ржи ржпржд ржЯрж╛ржХрж╛
                        ржЖржпрж╝ ржХрж░ржмрзЗржи рж╕рж╛ржерзЗ рж╕рж╛ржерзЗ рждржд ржЯрж╛ржХрж╛ ржЙржЗржержбрзНрж░
                        ржХрж░рждрзЗ ржкрж╛рж░ржмрзЗржи тЬЕ ржЖржорж╛ржжрзЗрж░ рж╕рж╛ржерзЗржЗ ржерж╛ржХрзБржи
                        ржзржирзНржпржмрж╛ржжЁЯТ╕ЁЯТЦ</marquee>
                </div>
                <!----------header ended-->

                <div class="container" style="margin-top: 24px; float: left;">
                    <div class="row" style="text-align: center;">
                        <div class="col"><a href="/user/deposit" style="text-decoration: none;">
                                <div class="iconbar">
                                    <div class="icon"> <img
                                            src="https://cdn-icons-png.flaticon.com/512/5304/5304640.png"
                                            style="width: 45px;" /></div>
                                    <span style="font-size: 10px;text-align: center;">Deposit</span>
                                </div>
                            </a>
                        </div>

                        <div class="col"><a href="/user/withdraw" style="text-decoration: none;">
                                <div class="iconbar">
                                    <div class="icon"> <img
                                            src="https://cdn-icons-png.flaticon.com/512/5501/5501360.png"
                                            style="width: 45px;" /></div>
                                    <span
                                        style="font-size: 10px;text-align: center;text-decoration: none;">Cashout</span>
                                </div>
                            </a>
                        </div>

                        <div class="col"><a href="/user/ptc" style="text-decoration: none;">
                                <div class="iconbar">
                                    <div class="icon"> <img
                                            src="https://cdn-icons-png.flaticon.com/128/3774/3774905.png"
                                            style="width: 45px;" /></div>
                                    <span
                                        style="font-size: 10px;text-align: center;text-decoration: none;margin-left: 10px;">Work</span>
                                </div>
                            </a>
                        </div>

                        <div class="col">
                            <a href="/user/referred-users" style="text-decoration: none;">
                                <div class="iconbar">
                                    <div class="icon"> <img
                                            src="https://static.vecteezy.com/system/resources/previews/022/973/168/original/gift-card-flat-icon-shopping-gift-card-earn-points-redeem-present-box-concept-vector-illustration-png.png"
                                            style="width: 45px;" /></div>
                                    <span style="font-size: 10px;text-align: center;text-decoration: none;">Total
                                        Earn</span>
                                </div>
                            </a>
                        </div>

                    </div>

                    <div class="row" style="text-align: center;">
                        <div class="col"><a href="/user/plans" style="text-decoration: none;">
                                <div class="iconbar">
                                    <div class="icon"> <img
                                            src="https://cdn-icons-png.flaticon.com/128/9398/9398952.png"
                                            style="width: 45px;" /></div>
                                    <span
                                        style="font-size: 10px;text-align: center;text-decoration: none;margin-left: 10px;">Plan
                                    </span>
                                </div>
                            </a>
                        </div>

                        <div class="col"><a href="/user/commissions" style="text-decoration: none;">
                                <div class="iconbar">
                                    <div class="icon"> <img
                                            src="https://cdn-icons-png.flaticon.com/512/10496/10496522.png"
                                            style="width: 45px;" /></div>
                                    <span
                                        style="font-size: 10px;text-align: center;text-decoration: none;">Commission</span>
                                </div>
                            </a>
                        </div>

                        <div class="col"><a href="/user/ptc" style="text-decoration: none;">
                                <div class="iconbar">
                                    <div class="icon"> <img
                                            src="https://static.vecteezy.com/system/resources/thumbnails/004/968/602/small/new-email-notification-on-mobile-phone-device-or-smartphone-concept-illustration-flat-design-eps10-vector.jpg"
                                            style="width: 45px;" /></div>
                                    <span
                                        style="font-size: 10px;text-align: center;text-decoration: none;margin-left: 10px;">Job</span>
                                </div>
                            </a>
                        </div>

                        <div class="col"><a href="#" style="text-decoration: none;">
                                <div class="iconbar">
                                    <div class="icon"> <img
                                            src="https://www.iconpacks.net/icons/2/free-chat-support-icon-1721-thumb.png"
                                            style="width: 45px;" /></div>
                                    <span
                                        style="font-size: 10px;text-align: center;text-decoration: none;margin-left: 10px;">Support</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>



                <div class="invite">
                    <div class="invite-img">
                        <img src="https://i.postimg.cc/qgfYPzLp/images-3.png" style="width: 100%;" />
                    </div>
                </div>

                <div class="container">
                    <div class="middle-section">
                        <div class="content">
                            <div class="card"
                                style="border: none; box-shadow: 0px 5px 20px #d9d9d9; margin-bottom:50px">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col"><a href="/user/deposit" style="text-decoration: none;">
                                                <div class="iconbar">
                                                    <div class="icon"><img
                                                            src="https://cdn-icons-png.flaticon.com/512/3936/3936019.png"
                                                            style="width: 45px;" /> </div>
                                                    <span
                                                        style="font-size: 10px;text-align: center;text-decoration: none;margin-left: 10px;">Pay</span>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col"><a href="/user/deposit/history"
                                                style="text-decoration: none;">
                                                <div class="iconbar">
                                                    <div class="icon"><img
                                                            src="https://static.vecteezy.com/system/resources/previews/013/484/033/original/digital-payment-3d-icon-png.png"
                                                            style="width: 45px;" /> </div>
                                                    <span style="font-size: 10px;text-decoration: none;">Payment</span>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col"><a href="/user/profile-setting"
                                                style="text-decoration: none;">
                                                <div class="iconbar">
                                                    <div class="icon"><img
                                                            src="https://cdn3d.iconscout.com/3d/premium/thumb/profile-6073860-4996977.png"
                                                            style="width: 45px;" /> </div>
                                                    <span
                                                        style="font-size: 10px;text-decoration: none; margin-left: 10px;">Profile</span>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col"><a href="/user/change-password"
                                                style="text-decoration: none;">
                                                <div class="iconbar">
                                                    <div class="icon"><img
                                                            src="https://png.pngtree.com/png-vector/20230409/ourmid/pngtree-password-icon-vector-png-image_6696962.png"
                                                            style="width: 45px;" /> </div>
                                                    <span
                                                        style="font-size: 10px;text-decoration: none;">Password</span>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="invite">
                                            <div class="invite-img">
                                                <a href="/user/referral"> <img
                                                        src="https://d1bdmzehmfm4xb.cloudfront.net/optimized/3X/5/5/551c7890dbe566d8ed8092cdbec2120907b4e6ed_2_800x333.gif"
                                                        style="width: 100%;border-radius: 10px;" /></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col"><a href="https://t.me/Tonmoy_8"
                                                style="text-decoration: none;">
                                                <div class="iconbar">
                                                    <div class="icon"><img src="/web-developer.png"
                                                            style="width: 45px;" /> </div>
                                                    <span
                                                        style="font-size: 10px;text-align: center;text-decoration: none;">Web-Dev</span>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col"><a href="#" style="text-decoration: none;">
                                                <div class="iconbar">
                                                    <div class="icon"><img
                                                            src="https://cdn-icons-png.flaticon.com/512/1802/1802636.png"
                                                            style="width: 45px;" /> </div>
                                                    <span
                                                        style="font-size: 10px;text-decoration: none;">Customer-Reviews!</span>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col"><a href="/user/deposit/history"
                                                style="text-decoration: none;">
                                                <div class="iconbar">
                                                    <div class="icon"><img
                                                            src="https://cdn-icons-png.flaticon.com/512/5180/5180799.png"
                                                            style="width: 45px;" /> </div>
                                                    <span
                                                        style="font-size: 10px;text-decoration: none;">DHistory</span>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col"><a href="/logout" style="text-decoration: none;">
                                                <div class="iconbar">
                                                    <div class="icon"><img
                                                            src="https://cdn-icons-png.flaticon.com/512/1053/1053210.png"
                                                            style="width: 45px;" /> </div>
                                                    <span style="font-size: 10px;text-decoration: none;">Logout</span>
                                                </div>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 w-screen">
                        <a target="_blank" href="https://t.me/Kt_devloper">
                            <div class="cursor-pointer flex items-center flex-col" style="margin-bottom: 50px;">
                                <div><img alt="" loading="lazy" width="1000" height="5000"
                                        decoding="async" data-nimg="1" class="w-full lg:h-[80vh]"
                                        srcset="https://procash99.com/assets/youtube.webp"
                                        src="https://procash99.com/assets/youtube.webp" style="color: transparent;">
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="certificate" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">License Certificate</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="img">
                                        <img src="../custom_images/certifecate.jpg" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        Now</button>
                                    <!----<button type="button" class="btn btn-primary">Save changes</button>------>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="work" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Work Summary</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="img">
                                        <img src="../custom_images/sum.png" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        Now</button>
                                    <!----<button type="button" class="btn btn-primary">Save changes</button>------>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="cmn-section">
                        <div hidden class="col-sm-12 col-md-12 col-lg-4">
                            <div class="card card-news">
                                <div class="card-header">
                                    <div class="card-title f1"><a href="/news.html">Headlines</a></div>
                                    <div class="card-options">
                                        <div class="text-muted mr-2">Official digital currency news</div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <ul class="list-unstyled">
                                        <li class="media mb-3">
                                            <img src="https://weswis.com/uploads/image/202206/13/62a68932d903c.png"
                                                class="w-7 h-7 mr-3" />
                                            <div class="media-body">
                                                <h5 class="mt-0 mb-1 text-truncate" style="max-width: 13rem;"><a
                                                        href="/article/14.html" class="font-weight-light">Event</a>
                                                </h5>
                                                <small class="text-muted"></small>
                                            </div>
                                        </li>
                                        <li class="media mb-3">
                                            <img src="https://weswis.com/uploads/image/202206/13/62a68932d903c.png"
                                                class="w-7 h-7 mr-3" />
                                            <div class="media-body">
                                                <h5 class="mt-0 mb-1 text-truncate" style="max-width: 13rem;"><a
                                                        href="/article/13.html" class="font-weight-light">Privacy</a>
                                                </h5>
                                                <small class="text-muted"></small>
                                            </div>
                                        </li>
                                        <li class="media mb-3">
                                            <img src="https://weswis.com/uploads/image/202205/11/627b8d721f34f.png"
                                                class="w-7 h-7 mr-3" />
                                            <div class="media-body">
                                                <h5 class="mt-0 mb-1 text-truncate" style="max-width: 13rem;"><a
                                                        href="/article/11.html" class="font-weight-light">Weswis
                                                        Income
                                                        Introduction</a></h5>
                                                <small class="text-muted"></small>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="modal fade modal-popup" id="modal-popup" tabindex="-1" role="dialog"
                    data-version="a3c1dc7efca0d2ffc136ad3a207da9ccd7efd337" aria-labelledby="exampleModalCenterTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Announcement weswis.com</h5>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p style="white-space: normal; text-align: center;"><strong>Welcome Dear
                                        User</strong><br /></p>
                                <p style="white-space: normal; text-align: center;"><span
                                        style="color: rgb(255, 0, 0);"><strong>WESWIS&nbsp;</strong></span><strong><span
                                            style="color: rgb(0, 176, 240);">COM</span></strong><span
                                        style="color: rgb(0, 176, 80);"></span><br /></p>
                                <p style="white-space: normal; text-align: left;"><strong><span
                                            style="color: rgb(0, 176, 240);">WESWIS&nbsp;</span></strong><span
                                        style="color: rgb(255, 255, 255);"><strong>is the best virtual currency mining
                                            platform in asia as well as investment<br /></strong></span></p>
                                <p style="white-space: normal; text-align: left;"><span
                                        style="color: rgb(255, 255, 255);"><strong>Remember there is no instant money
                                            unless you work, pray and try</strong></span></p>
                                <p style="white-space: normal; text-align: left;"><span
                                        style="color: rgb(0, 0, 0);"><strong><br /></strong></span></p>
                                <p style="white-space: normal; text-align: left;"><span
                                        style="color: rgb(255, 0, 0);"><strong>WESWIS
                                        </strong></span><strong>Lauched</strong><span
                                        style="color: rgb(0, 176, 80);"><strong>&nbsp;on January 10,
                                            2022</strong></span>
                                </p>
                                <p style="white-space: normal; text-align: left;"><strong>We are licensed and
                                        officially
                                        become a mining and investment platform for companies</strong></p>
                                <p style="white-space: normal; text-align: left;"><strong>The rest you can explore in
                                        our
                                        company</strong></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">I'll do it
                                    soon</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade modal-group" id="modal-group" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">exchange group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    11111 </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<style>
    .appBottomMenu {
        display: flex;
        justify-content: space-around;
        align-items: center;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #fff;
        /* Change color as needed */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 10px 0;
        z-index: 1000;
    }

    .appBottomMenu .item {
        flex: 1;
        text-align: center;
        text-decoration: none;
        color: #333;
        /* Set a default color for icons and text */
    }

    .appBottomMenu .item .col img {
        display: block;
        margin: 0 auto;
        max-width: 25%;
        /* Image will not exceed the container's width */
        height: auto;
        /* Maintain the image aspect ratio */
    }

    .appBottomMenu .item .col img {
        display: block;
        margin: 0 auto;
    }

    .appBottomMenu .item strong {
        display: block;
        font-size: 12px;
        /* Adjust font size as needed */
        margin-top: 4px;
        color: inherit;
    }

    .mt-1 {
        font-width: bold;
        font-size: 15px;
        color: #000;
        text-align: center;
        margin-top: 0.25rem;
    }
</style>

<!-- footer -->
<footer class="footer d-xs-none d-sm-none d-lg-block">
    <div class="appBottomMenu mt-5 border">
        <a href="/user/dashboard" class="item">
            <div class="col">
                <img height="27px" src="https://procash99.com/assets/icon/home.png" alt="">
                <strong>Home</strong>
            </div>
        </a>
        <a href="/user/transactions" class="item ">
            <div class="col">
                <img height="27px" src="https://procash99.com/assets/icon/transaction.png" alt="">
                <strong>Transaction</strong>
            </div>
        </a>
        <a href="/user/ptc-clicks" class="item ">
            <div class="col">
                <img height="27px" src="https://procash99.com/assets/icon/earn.png" alt="">
                <strong>Total Earn</strong>
            </div>
        </a>
        <a href="/user/profile-setting" class="item">
            <div class="col">
                <img height="27px" src="https://procash99.com/assets/icon/profile.png" alt="">
                <strong>Profile</strong>
            </div>
        </a>
    </div>
</footer>
<!-- script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://www.ustearn.com/assets/custom/assets/templates/basic//assets/js/require.min.js"></script>
<!-- custom select js -->
<script src="https://www.ustearn.com/assets/custom/assets/templates/basic//static/js/global.js?v=1674579672"></script>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://www.ustearn.com/assets/custom/assets/global/js/jquery-3.6.0.min.js"></script>
<script src="https://www.ustearn.com/assets/custom/assets/global/js/bootstrap.bundle.min.js"></script>

<!-- lightcase plugin -->
<script src="https://www.ustearn.com/assets/custom/assets/templates/basic//js/vendor/lightcase.js"></script>
<!-- custom select js -->
<script src="https://www.ustearn.com/assets/custom/assets/templates/basic//js/vendor/jquery.nice-select.min.js">
</script>
<!-- slick slider js -->
<script src="https://www.ustearn.com/assets/custom/assets/templates/basic//js/vendor/slick.min.js"></script>
<!-- scroll animation -->
<script src="https://www.ustearn.com/assets/custom/assets/templates/basic//js/vendor/wow.min.js"></script>
<!-- dashboard custom js -->
<script src="https://www.ustearn.com/assets/custom/assets/templates/basic//js/app.js"></script>

<script>
    require(['core', 'jquery'], function(core, $) {
        $(function() {
            // ш┤жхП╖хРМцне
            setTimeout(function() {
                ajax(api.account.sync, {}, function() {});
            }, 500);
            // хЕмхСКщАЪчЯе
            if ($('.modal-popup').length) {
                var version = $('.modal-popup').data('version');
                if (localStorage) {
                    if (localStorage.popup != version) {
                        $('.modal-popup').modal();
                        localStorage.popup = version;
                    }
                } else {
                    $('.modal-popup').modal();
                }
            }
        });
    });
</script>

<script src="https://www.ustearn.com/assets/custom/assets/admin/js/vendor/apexcharts.min.js"></script>
<script>
    (function($) {
        "use strict";
        // apex-bar-chart js
        var options = {
            series: [{
                name: 'Clicks',
                data: []
            }, {
                name: 'Earn Amount',
                data: []
            }],
            chart: {
                type: 'bar',
                height: 580,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: [],
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
        chart.render();

        function createCountDown(elementId, sec) {
            var tms = sec;
            var x = setInterval(function() {
                var distance = tms * 1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML = days + "d: " + hours + "h " + minutes +
                    "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "COMPLETE";
                }
                tms--;
            }, 1000);
        }
        createCountDown('counter', 25732);
    })(jQuery);
</script>
<script>
    let balanceVisible = false;
    const balanceIcon = document.querySelector('.balance-icon');

    function toggleBalance() {
        const balanceAmount = document.getElementById('balanceAmount');
        const balanceText = document.querySelector('.balancebar');

        balanceVisible = !balanceVisible;

        if (balanceVisible) {
            balanceText.style.display = 'none';
            balanceAmount.style.display = 'inline-block';
            balanceIcon.style.transition = 'transform 0.5s ease-in-out';
            balanceIcon.style.transform = 'translateX(95px)'; // Adjust the distance as needed

            setTimeout(() => {
                balanceAmount.style.display = 'none';
                balanceText.style.display = 'inline-block';
                balanceIcon.style.transform = 'translateX(0)';
                balanceVisible = false;
            }, 3000); // Adjust the duration (in milliseconds) as needed

            // Automatically reset the icon after a delay
            setTimeout(() => {
                balanceIcon.style.transition = 'none';
                balanceIcon.style.transform = 'translateX(0)';
            }, 4000); // Adjust the delay before resetting (in milliseconds) as needed
        }
    }
</script>

<link rel="stylesheet" href="https://www.ustearn.com/assets/custom/assets/global/css/iziToast.min.css">
<script src="https://www.ustearn.com/assets/custom/assets/global/js/iziToast.min.js"></script>

<script>
    "use strict";

    function notify(status, message) {
        iziToast[status]({
            message: message,
            position: "topRight"
        });
    }
</script>

<script>
    //-- Notify --//
    const notifyMsg = (msg, cls) => {

        Swal.fire({
            position: 'top-end',
            icon: cls,
            title: msg,
            toast: true,
            showConfirmButton: false,
            timer: 2100
        })
    }
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script src="https://www.ustearn.com/assets/global/js/notiflix-aio-2.7.0.min.js"></script>

</body>

</html>
