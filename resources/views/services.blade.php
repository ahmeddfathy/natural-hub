@extends('layouts.app')

@section('title', '??????? | Natural Hub — ????? ???? ???????? ????????')
@section('meta_description', '????? Natural Hub — ?????? ???? ????? ????? ????? ?????? ?????. ????? ?? ??????? ?????????? ?????? ????? ?? ??????????.')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/services.css') }}">
@endpush

@section('content')

    <!-- ===== MASTER HERO ===== -->
    <section class="master-hero mh-centered" id="services-hero">
        <div class="mh-bg">
            <div class="mh-overlay"></div>
            <div class="mh-glows"></div>
            <div class="mh-particles">
                <span class="p1"></span><span class="p2"></span><span class="p3"></span><span class="p4"></span>
            </div>
        </div>
        <div class="container mh-inner">
            <div class="mh-content">
                <span class="mh-tag"><i class="fas fa-spa"></i> ??????? ?????????</span>
                <h1 class="mh-title">????? ????? <br><span class="mh-accent">??? ????????</span></h1>
                <p class="mh-desc">???? ??? ?????? ?????? ?? ???? ????? ??????? ?????? ??????? ???????? ????? ?????? ????? ?????? ??????? ??????? ????? ???? ?????????.</p>
                <div class="mh-btns">
                    <a href="#hair" class="mh-btn-primary">??? ???????</a>
                    <a href="https://wa.me/201001234567" class="mh-btn-outline" target="_blank"><i class="fab fa-whatsapp"></i> ????? ??????</a>
                </div>
        </div>
    </section>

    <!-- ===== STICKY CATEGORY TABS ===== -->
    <div class="srv-tabs-bar" id="srvTabsBar">
        <div class="container srv-tabs-inner">
            <button class="srv-tab active" data-target="cat-hair">
                <i class="fas fa-wand-magic-sparkles"></i> ?????
            </button>
            <button class="srv-tab" data-target="cat-skin">
                <i class="fas fa-sun"></i> ??????
            </button>
            <button class="srv-tab" data-target="cat-lash">
                <i class="fas fa-eye"></i> ??????
            </button>
            <button class="srv-tab" data-target="cat-aftercare">
                <i class="fas fa-box-open"></i> ?????? ???
            </button>
        </div>
    </div>

    <!-- ===== SERVICES GRID ===== -->
    <main class="srv-main" id="services-grid">

        <!-- --------------------------
             ?????
        -------------------------- -->
        <section class="srv-cat" id="cat-hair">
            <div class="container">
                <div class="srv-cat-head">
                    <div class="srv-cat-label">
                        <div class="srv-cat-icon hair-icon"><i class="fas fa-wand-magic-sparkles"></i></div>
                        <div>
                            <h2>?????? ?????? ?????</h2>
                            <p>?????? ???? ???????? ???????? (????????? ???????? ???????) • ????? ?????? ?? ?????? ???? ????? ??? ?.?</p>
                        </div>
                    </div>
                    <a href="https://wa.me/201001234567" class="srv-cat-book" target="_blank">
                        <i class="fab fa-whatsapp"></i> ????? ????
                    </a>
                </div>

                <div class="srv-cards">

                    <!-- Nano Hydration -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/sallon.jpeg" alt="Nano Hydration" loading="lazy">
                            <div class="srv-card-cat hair-cat">????? ?????? ??</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">Nano Hydration</h3>
                            <p class="srv-card-desc">???? ?????? ???? ???? ??????? ?????. ???? ???????? ???? ????? ????? ??????? ????? ???? ????? ?????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-clock"></i> ??????</span>
                                <span><i class="fas fa-sync-alt"></i> ???? ? ????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">???? ??</span>
                                    <span class="srv-price-val">???? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ???? Nano Hydration" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Detox Hair Repairing -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/1.jpeg" alt="Detox hair repairing" loading="lazy">
                            <div class="srv-card-cat hair-cat">????? ??????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">Detox Hair Repairing</h3>
                            <p class="srv-card-desc">????? ????? ????? ??? ??%. ???? ??????? ???? ???????. ????? ????? ?????? ???????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-clock"></i> ? ?????</span>
                                <span><i class="fas fa-sync-alt"></i> ???? ?-? ????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">???? ??</span>
                                    <span class="srv-price-val">???? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ???? Detox hair repairing" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Nano Plasma Treatment -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a1.jpeg" alt="Nano Plasma Treatment" loading="lazy">
                            <div class="srv-card-cat hair-cat">????? ??????? ?</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">Nano Plasma Treatment</h3>
                            <p class="srv-card-desc">????? ?????? ????? ?????? ?? ??? ??%. ????? ????? ????? ???? ?????? ?????? ?????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-clock"></i> ? ?????</span>
                                <span><i class="fas fa-sync-alt"></i> ???? ?-? ????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">???? ??</span>
                                    <span class="srv-price-val">???? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ???? Nano Plasma" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Argan Treatment -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/2jpeg.jpeg" alt="Argan Treatment" loading="lazy">
                            <div class="srv-card-cat hair-cat">???? ??????? ????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">Argan Treatment</h3>
                            <p class="srv-card-desc">??? ?? ??% ??? ???%. ????? ?????? ???????? ?????? ????? ????? ?????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-clock"></i> ? ?????</span>
                                <span><i class="fas fa-sync-alt"></i> ???? ? ????+</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">???? ??</span>
                                    <span class="srv-price-val">???? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ???? Argan Treatment" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- American Argan -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/sallon.jpeg" alt="American Argan" loading="lazy">
                            <div class="srv-card-cat hair-cat">???? ?????? ????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">American Argan</h3>
                            <p class="srv-card-desc">???? ???? ????? ?????? ????? ??????????. ???? ?????? ????? ????? ???? ??%.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-clock"></i> ? ?????</span>
                                <span><i class="fas fa-sync-alt"></i> ???? ? ????+</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">???? ??</span>
                                    <span class="srv-price-val">???? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? American Argan" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- CHI Enviro -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/1.jpeg" alt="CHI Enviro" loading="lazy">
                            <div class="srv-card-cat hair-cat">???? ?? ????????????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">CHI Enviro</h3>
                            <p class="srv-card-desc">???? ??????? ?????? ????? ?????? ??????? ???? ????? ??????? ???????. ???? ???? ??????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-leaf"></i> ??? ????</span>
                                <span><i class="fas fa-sync-alt"></i> ???? ?-? ????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">???? ??</span>
                                    <span class="srv-price-val">???? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? CHI Enviro" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Filler Treatment -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a3.jpeg" alt="Filler Treatment" loading="lazy">
                            <div class="srv-card-cat hair-cat">???? ?????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">Filler Treatment</h3>
                            <p class="srv-card-desc">???? ??? ??% ?? ???? ?????? ????????. ????? ????? ?????? ?????? ?? ???????? ???????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-clock"></i> ? ?????</span>
                                <span><i class="fas fa-sync-alt"></i> ???? ? ????+</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">???? ??</span>
                                    <span class="srv-price-val">???? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ???? Filler" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Caviar / Green Caviar -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a4.jpeg" alt="Caviar Treatment" loading="lazy">
                            <div class="srv-card-cat hair-cat">????? ???????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">Caviar & Green Caviar</h3>
                            <p class="srv-card-desc">??? ??-???%. ????? ????? ??????? ?????? ??????? ????? ????????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-clock"></i> ? ?????</span>
                                <span><i class="fas fa-sync-alt"></i> ???? ? ????+</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">???? ??</span>
                                    <span class="srv-price-val">???? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ???? Caviar" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Hyaluronic treatment -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a5.jpeg" alt="Hyaluronic treatment" loading="lazy">
                            <div class="srv-card-cat hair-cat">????? ???? ??</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">Hyaluronic Treatment</h3>
                            <p class="srv-card-desc">??? ??-???% ?? ???? ????. ???? ????????????? ????? ?????? ???? ?????? ?????????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-clock"></i> ? ?????</span>
                                <span><i class="fas fa-sync-alt"></i> ???? ? ????+</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">???? ??</span>
                                    <span class="srv-price-val">???? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? Hyaluronic" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Japanese Hair Treatment -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a6.jpeg" alt="Japanese Hair Treatment" loading="lazy">
                            <div class="srv-card-cat hair-cat">??????? ????????? ????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">Japanese Treatment</h3>
                            <p class="srv-card-desc">????? ????? ?????? ???? ???????. ????? ??? ??? ???????? ????? ???? ??? ????? ???? ??%.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-clock"></i> ? ?????</span>
                                <span><i class="fas fa-sync-alt"></i> ???? ? ????+</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">???? ??</span>
                                    <span class="srv-price-val">???? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? Japanese Treatment" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Ceramide Treatment -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a7.jpeg" alt="Ceramide Treatment" loading="lazy">
                            <div class="srv-card-cat hair-cat">????? ???????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">Ceramide Treatment</h3>
                            <p class="srv-card-desc">????? ????? ??????? ?? ?????? ???????? ????? ???? ?????. ???? ??? ??? ??? ??%.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-clock"></i> ? ?????</span>
                                <span><i class="fas fa-sync-alt"></i> ???? ? ????+</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">???? ??</span>
                                    <span class="srv-price-val">???? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? Ceramide Treatment" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Marrow Treatment -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a8.jpeg" alt="Marrow Treatment" loading="lazy">
                            <div class="srv-card-cat hair-cat">??????? ??????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">Marrow Treatment</h3>
                            <p class="srv-card-desc">????? ??? ?????? ?????? ???????? ????? ??????????? ???????. ??? ??% ?? ????? ????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-clock"></i> ? ?????</span>
                                <span><i class="fas fa-sync-alt"></i> ???? ?-? ????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">?????</span>
                                    <span class="srv-price-val">???? ???</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? Marrow Treatment" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- --------------------------
             ??????
        -------------------------- -->
        <section class="srv-cat srv-cat-alt" id="cat-skin">
            <div class="container">
                <div class="srv-cat-head">
                    <div class="srv-cat-label">
                        <div class="srv-cat-icon skin-icon"><i class="fas fa-sun"></i></div>
                        <div>
                            <h2>????? ??????? ???????</h2>
                            <p>????? ?????? ??????? ????? ?? ??? ?? ?????? ???????? ???? ??????? ????????? ??????</p>
                        </div>
                    </div>
                    <a href="https://wa.me/201001234567" class="srv-cat-book skin-book" target="_blank">
                        <i class="fab fa-whatsapp"></i> ????? ????
                    </a>
                </div>

                <div class="srv-cards">

                    <!-- Deep Cleansing -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a1.jpeg" alt="????? ????" loading="lazy">
                            <div class="srv-card-cat skin-cat">??????????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">???? ??????? ??????</h3>
                            <p class="srv-card-desc">????? ???? ????? ?????????? ?????? ??????? ??????? ?????? ?????????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-clock"></i> ??????</span>
                                <span><i class="fas fa-flask"></i> ?????? ????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">?????</span>
                                    <span class="srv-price-val skin-price">??? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ???? ????? ??????" class="srv-book-btn skin-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Crystal Peel -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a2.jpeg" alt="????? ????????" loading="lazy">
                            <div class="srv-card-cat skin-cat">??????? ???</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">???? ??????? ??????????</h3>
                            <p class="srv-card-desc">????? ???? ?????? ?????? ?????? ???????? ???? ??????? ??? ?????????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-magic"></i> ????? ?????</span>
                                <span><i class="fas fa-sync-alt"></i> ????? ?????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">?????</span>
                                    <span class="srv-price-val skin-price">??? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ??????? ??????????" class="srv-book-btn skin-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Glass Skin -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a5.jpeg" alt="?????? ????????" loading="lazy">
                            <div class="srv-card-cat skin-cat">Glass Skin</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">???? ?????? ????????</h3>
                            <p class="srv-card-desc">?????? ?????? ??????? ?? ??????? ???? ?????? ??? ???? ???? ???? ??????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-gem"></i> ???? ??????</span>
                                <span><i class="fas fa-leaf"></i> ????? ???????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">?????</span>
                                    <span class="srv-price-val skin-price">??? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ???? ?????? ????????" class="srv-book-btn skin-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Oxygeneo -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a4.jpeg" alt="???? ????????" loading="lazy">
                            <div class="srv-card-cat skin-cat">?????? ??????? ??</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">???? ????????</h3>
                            <p class="srv-card-desc">????? ??? ? ?????? ???? ????????? ????? ?????????? ?????? ?????? ?? ???? ?????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-bolt"></i> ? ????? ?????</span>
                                <span><i class="fas fa-star"></i> ???? ???????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">?????</span>
                                    <span class="srv-price-val skin-price">???? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ???? ????????" class="srv-book-btn skin-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Dermapen -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a2.jpeg" alt="???????" loading="lazy">
                            <div class="srv-card-cat skin-cat">???? ???????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">????? ?????????</h3>
                            <p class="srv-card-desc">???? ????? ????????? ?????? ???????? ??????? ???????? ?????? ??????? ?????? ?????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-vial"></i> ????? ?????</span>
                                <span><i class="fas fa-user-md"></i> ????? ????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">?????</span>
                                    <span class="srv-price-val skin-price">??? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ???? ???????" class="srv-book-btn skin-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- --------------------------
             ?????? ????????
        -------------------------- -->
        <section class="srv-cat" id="cat-lash">
            <div class="container">
                <div class="srv-cat-head">
                    <div class="srv-cat-label">
                        <div class="srv-cat-icon lash-icon"><i class="fas fa-eye"></i></div>
                        <div>
                            <h2>?????? ????????</h2>
                            <p>????? ???? Mink ????? Hair by Hair ??????? ??? ??????? ??????? ??????????</p>
                        </div>
                    </div>
                    <a href="https://wa.me/201001234567" class="srv-cat-book lash-book" target="_blank">
                        <i class="fab fa-whatsapp"></i> ????? ????
                    </a>
                </div>

                <div class="srv-cards">

                    <!-- Classic Lashes -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a7.jpeg" alt="???? ??????" loading="lazy">
                            <div class="srv-card-cat lash-cat">Mink Natural</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">???? ??????</h3>
                            <p class="srv-card-desc">????? ??? ??? ????? ????? ??????. ????? ???? ??????? ?????? ???????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-clock"></i> ?-? ?????</span>
                                <span><i class="fas fa-sync-alt"></i> ????? ???? ? ???? ??????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">????? / ?????</span>
                                    <span class="srv-price-val lash-price">??? / ??? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ???? ??????" class="srv-book-btn lash-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Hybrid Lashes -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a7.jpeg" alt="???? ??????" loading="lazy">
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">???? ??????</h3>
                            <p class="srv-card-desc">???? ??? ???????? ????????? ?????? ?????? ????? ????? ????????? ??????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-eye"></i> ???? ?????</span>
                                <span><i class="fas fa-check"></i> ????? ?????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">????? / ?????</span>
                                    <span class="srv-price-val lash-price">??? / ??? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ?????? ????????" class="srv-book-btn lash-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Volume Lashes -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a8.jpeg" alt="???? ??????" loading="lazy">
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">???? ??????</h3>
                            <p class="srv-card-desc">????? ?????? ???? ???? ????? ??????? ?????? ?? ????????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-star"></i> ????? ?????</span>
                                <span><i class="fas fa-smile"></i> ????? ??????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">????? / ?????</span>
                                    <span class="srv-price-val lash-price">???? / ??? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ?????? ????????" class="srv-book-btn lash-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Mega Volume -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a8.jpeg" alt="???? ??????" loading="lazy">
                            <div class="srv-card-cat lash-cat">?????? ??????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">???? ??????</h3>
                            <p class="srv-card-desc">???? ????? ??????? ??????? ????? ?? ?????????. ????? ??????? ?? ???? ??? ?????? ????????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-crown"></i> ???? ????</span>
                                <span><i class="fas fa-shield-alt"></i> ???? ?????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">????? / ?????</span>
                                    <span class="srv-price-val lash-price">???? / ??? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ?????? ??????" class="srv-book-btn lash-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Brow Lamination -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a4.jpeg" alt="??? ?????" loading="lazy">
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">Brow Lamination</h3>
                            <p class="srv-card-desc">????? ??? ??????? ???????? ???? ???? ????? ???? ?? ? ??? ? ??????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-paint-brush"></i> ?? ?? ???? ????</span>
                                <span><i class="fas fa-clock"></i> ?? ?????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">?????</span>
                                    <span class="srv-price-val lash-price">??? /??? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ??? ???????" class="srv-book-btn lash-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Lash Lifting -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a3.jpeg" alt="??? ????" loading="lazy">
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">Lash Lifting</h3>
                            <p class="srv-card-desc">??? ?????? ?????? ???????? ???? ?????. ???? ???? ????? ????? ???? ?????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-eye"></i> ????? ????</span>
                                <span><i class="fas fa-sync-alt"></i> ???? ? ??????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">?????</span>
                                    <span class="srv-price-val lash-price">??? / ??? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=??????? ???? ????????? ?? ??? ??????" class="srv-book-btn lash-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    <!-- Lash Remover -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/b&a4.jpeg" alt="????? ??????" loading="lazy">
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">????? ?????? (Lash Remover)</h3>
                            <p class="srv-card-desc">????? ???????? ????? ?????? ???????? ???? ????? ?? ???? ?? ??? ?????? ????????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-shield-alt"></i> ???? ??????</span>
                                <span><i class="fas fa-clock"></i> ?? ?????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <span class="srv-price-from">?????</span>
                                    <span class="srv-price-val lash-price">??? ?</span>
                                </div>
                                <a href="https://wa.me/201001234567?text=???? ??? ???? ????? ????" class="srv-book-btn lash-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- --------------------------
             ?????? ?????? ???
        -------------------------- -->
        <section class="srv-cat srv-cat-alt" id="cat-aftercare">
            <div class="container">
                <div class="srv-cat-head">
                    <div class="srv-cat-label">
                        <div class="srv-cat-icon bridal-icon"><i class="fas fa-box-open"></i></div>
                        <div>
                            <h2>??????? ?????? ???</h2>
                            <p>????? ??? ????? ????? ????? ???? ????? ?? ??????? ??????? ????????</p>
                        </div>
                    </div>
                </div>

                <div class="srv-cards">

                    <!-- Pink Set -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/1.jpeg" alt="Aftercare Pink" loading="lazy">
                            <div class="srv-card-cat skin-cat">????? ?????? ???????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">???????? ??????? (Pink)</h3>
                            <p class="srv-card-desc">?????? ??????? (?????? ????? ?????? ???? ????) ????? ?????? ????? ?????? ???????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-bottle-water"></i> ???? ??? / ??? ???</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <div style="font-size: 0.8rem; opacity: 0.8;">???? ??: ???? ?</div>
                                    <div style="font-size: 0.8rem; opacity: 0.8;">??? ??: ??? ?</div>
                                </div>
                                <a href="https://wa.me/201001234567?text=???? ??? ?????? ?????? ??? ??????" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Green Set -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/2jpeg.jpeg" alt="Aftercare Green" loading="lazy">
                            <div class="srv-card-cat hair-cat">????? ???????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">???????? ??????? (Green)</h3>
                            <p class="srv-card-desc">?????? ??????? ????? ??? ??? ?????? ????? ????? ??????? ?? ???????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-palette"></i> ????? ?????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <div style="font-size: 0.8rem; opacity: 0.8;">???? ??: ???? ?</div>
                                    <div style="font-size: 0.8rem; opacity: 0.8;">??? ??: ??? ?</div>
                                </div>
                                <a href="https://wa.me/201001234567?text=???? ??? ?????? ?????? ??? ???????" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Black Set -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/sallon.jpeg" alt="Aftercare Black" loading="lazy">
                            <div class="srv-card-cat lash-cat">????? ?????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">???????? ??????? (Black)</h3>
                            <p class="srv-card-desc">????? ???? ???? ????? ???? ??????? ???? ??????? ???????? ?? ??? ???????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-tint"></i> ????? ????</span>
                            </div>
                            <div class="srv-card-footer">
                                <div class="srv-price">
                                    <div style="font-size: 0.8rem; opacity: 0.8;">???? ??: ???? ?</div>
                                    <div style="font-size: 0.8rem; opacity: 0.8;">??? ??: ??? ?</div>
                                </div>
                                <a href="https://wa.me/201001234567?text=???? ??? ?????? ?????? ??? ???????" class="srv-book-btn" target="_blank">?????</a>
                            </div>
                        </div>
                    </div>

                    <!-- Individual Items -->
                    <div class="srv-card">
                        <div class="srv-card-img">
                            <img src="assets/images/2jpeg.jpeg" alt="Individual Aftercare" loading="lazy">
                            <div class="srv-card-cat skin-cat">?????? ?????</div>
                        </div>
                        <div class="srv-card-body">
                            <h3 class="srv-card-title">????? ??????? ???????</h3>
                            <p class="srv-card-desc">????? ???? ?? ???? ?? ???????? ???? ????? ??? ???????.</p>
                            <div class="srv-card-details">
                                <span><i class="fas fa-tag"></i> ????? ?????</span>
                            </div>
                            <div class="srv-price-list" style="margin: 15px 0; font-size: 0.9rem; color: #666; border-top: 1px solid #eee; padding-top: 10px;">
                                <div style="display:flex; justify-content:space-between; margin-bottom:5px;"><span>????? / ???? (???? ???)</span> <strong>??? ?</strong></div>
                                <div style="display:flex; justify-content:space-between; margin-bottom:5px;"><span>???? ???? (??? ???)</span> <strong>??? ?</strong></div>
                                <div style="display:flex; justify-content:space-between; margin-bottom:5px;"><span>????? (??? ???)</span> <strong>??? ?</strong></div>
                                <div style="display:flex; justify-content:space-between;"><span>????? / ???? (??? ???)</span> <strong>??? ?</strong></div>
                            </div>
                            <div class="srv-card-footer">
                                <a href="https://wa.me/201001234567?text=???? ????????? ?? ?????? ?????? ??? ???????" class="srv-book-btn" style="width:100%; text-align:center;" target="_blank">????? ????</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>


    <!-- ===== BOOKING FORM ===== -->
    <section class="srv-booking-section" id="book-now">
        <div class="container">
            <div class="srv-booking-wrap">
                <div class="srv-booking-info">
                    <div class="srv-cta-icon"><i class="fas fa-calendar-check"></i></div>
                    <h2>????? ????? <span>????</span></h2>
                    <p>??????? ???? ?????? ?????? ?????? ?? ???? ???</p>
                    <div class="booking-perks">
                        <div class="perk-item"><i class="fas fa-check-circle"></i> ?????? - ???? ???? ???</div>
                        <div class="perk-item"><i class="fas fa-check-circle"></i> ????? ???? ??? ?? ????</div>
                        <div class="perk-item"><i class="fas fa-check-circle"></i> ??????? ??????? ?? ???????</div>
                    </div>
                    <a href="https://wa.me/201001234567" class="srv-btn-wa" target="_blank">
                        <i class="fab fa-whatsapp"></i> ?? ?????? ??? ??????
                    </a>
                </div>
                <div class="srv-booking-form-wrap">
                    @if(session('booking_success'))
                    <div class="booking-success-msg">
                        <i class="fas fa-check-circle"></i>
                        <div><strong>?? ?????? ????!</strong><p>??????? ???? ??????.</p></div>
                    </div>
                    @endif
                    @if($errors->any())
                    <div class="booking-errors">
                        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                    @endif
                    <form class="srv-booking-form" method="POST" action="{{ route('api.book') }}">
                        @csrf
                        <div class="sbf-row">
                            <div class="sbf-group">
                                <label><i class="fas fa-user"></i> ?????</label>
                                <input type="text" name="customer_name" value="{{ old('customer_name') }}" placeholder="???? ??????" required>
                                @error('customer_name')<span class="sbf-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="sbf-group">
                                <label><i class="fas fa-phone"></i> ??? ??????</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="01XXXXXXXXX" required>
                                @error('phone')<span class="sbf-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="sbf-group">
                            <label><i class="fas fa-spa"></i> ??????</label>
                            <div class="sbf-select-wrap">
                                <select name="service_id" required>
                                    <option value="" disabled {{ !old('service_id') ? 'selected':'' }}>?????? ??????</option>
                                    @if(isset($services) && $services->count())
                                        @foreach($services->groupBy('category_type') as $cat => $items)
                                            <optgroup label="{{ $cat }}">
                                                @foreach($items as $srv)
                                                    <option value="{{ $srv->id }}" {{ old('service_id') == $srv->id ? 'selected':'' }}>
                                                        {{ $srv->title }}{{ $srv->price_label ? ' ('.$srv->price_label.')' : '' }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    @endif
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            @error('service_id')<span class="sbf-error">{{ $message }}</span>@enderror
                        </div>
                        @if(isset($branches) && $branches->count() > 1)
                        <div class="sbf-group">
                            <label><i class="fas fa-map-marker-alt"></i> ?????</label>
                            <div class="sbf-select-wrap">
                                <select name="branch_id">
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected':'' }}>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        @elseif(isset($branches) && $branches->count() === 1)
                            <input type="hidden" name="branch_id" value="{{ $branches->first()->id }}">
                        @endif
                        <div class="sbf-group">
                            <label><i class="fas fa-calendar-alt"></i> ??????? ??????</label>
                            <input type="datetime-local" name="appointment_at" value="{{ old('appointment_at') }}" required>
                            @error('appointment_at')<span class="sbf-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="sbf-group">
                            <label><i class="fas fa-comment-dots"></i> ??????? (???????)</label>
                            <textarea name="notes" rows="2" placeholder="?? ?????? ??????...">{{ old('notes') }}</textarea>
                        </div>
                        <button type="submit" class="sbf-submit">
                            <i class="fas fa-calendar-check"></i> ????? ?????
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/services.js') }}"></script>
@endpush
