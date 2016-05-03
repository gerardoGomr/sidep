@extends('app')

@section('contenido')
    <div class="row row-app email">
        <!-- col -->
        <div class="col-md-12">
            <div class="col-separator col-unscrollable box col-separator-first">
                <div class="row row-app">
                    <div class="col-lg-4 col-md-6" id="email_list">
                        <div class="col-separator col-unscrollable box">
                            <div class="col-table">
                                <div class="input-group input-group-lg border-bottom">
                                    <span class="input-group-btn">
                                        <a href="" class="btn"><i class="fa fa-search text-muted"></i></a>
                                    </span>
                                    <input type="text" class="form-control border-none" placeholder="Buscar">
                                </div>

                                <div class="col-table-row">
                                    <div class="col-app col-unscrollable">
                                        <div class="col-app">

                                        </div>
                                        <!-- // END col-app -->
                                    </div>
                                    <!-- // END col-app -->
                                </div>
                                <!-- // END col-table-row -->
                            </div>
                            <!-- // END col-table -->
                        </div>
                        <!-- // END col-separator -->
                    </div>
                    <!-- // END col -->

                    <div class="col-lg-8 col-md-6 hidden-sm hidden-xs" id="email_details">
                        <div class="col-separator col-unscrollable col-separator-last">
                            <div class="col-table">
                                <div class="innerAll border-bottom bg-gray text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-default"><i class="fa fa-reply"></i></a>
                                        <a href="#" class="btn btn-default"><i class="fa fa-forward"></i></a>
                                        <a href="#" class="btn btn-primary"><i class="fa fa-trash-o"></i></a>
                                    </div>
                                    <button class="btn btn-sm btn-inverse" id="close-email-details"><i class="fa fa-fw fa-times"></i></button>
                                </div>

                                <div class="col-table-row">
                                    <div class="col-app col-unscrollable">
                                        <div class="col-app">

                                            <div class="innerAll border-bottom inner-2x">
                                                <div class="media innerB">
                                                    <img src="{{ url('resources/assets/images/people/80/8.jpg') }}" alt="" width="50" class="pull-left" />
                                                    <div class="media-body innerT half">

                                                        <small class="text-muted pull-right">28 October 2013</small>

                                                        <h5 class="text-muted-darker">MosaicPro <span class="text-weight-regular">(Me)</span></h5>
                                                        <h5 class="text-muted-dark text-weight-normal">To: Yun Ragna</h5>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <h4 class="innerT margin-none"><i class="fa fa-fw fa-circle-o text-success"></i> RE: Web Application Inquiry</h4>
                                            </div>
                                            <div class="innerAll">
                                                <div class="innerAll">
                                                    <p>Hi Yun,</p>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, libero corporis ipsam voluptatibus suscipit eos expedita sapiente omnis voluptatum ea! Culpa, vitae eaque quis modi voluptatum quisquam ullam. Modi, tempora!</p>
                                                    <p class="text-muted margin-none">Regards,<br/>mosaicpro </br>Director @ mosaicpro.biz</br>www.mosaicpro.biz</p>
                                                </div>
                                            </div>
                                            <div class="innerAll border-top">
                                                <p class="margin-none innerAll text-muted-dark"><i class="fa fa-quote-left fa-4x pull-left"></i> Aliquam rutrum, sem at scelerisque tempor, nulla diam pulvinar tortor, id pulvinar massa velit eu purus. Curabitur eu fringilla diam, sed suscipit lorem. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras iaculis enim vel odio imperdiet faucibus. Aliquam erat volutpat.</p>
                                            </div>
                                            <div class="innerAll bg-gray border-top">
                                                <div class="media inline-block margin-none">
                                                    <div class="innerLR">
                                                        <i class="fa fa-paperclip pull-left fa-2x"></i>
                                                        <div class="media-body">
                                                            <div><a href="" class="strong text-regular">Project.zip</a></div>
                                                            <span>15 MB</span>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <div class="media inline-block margin-none">
                                                    <div class="innerLR border-left">
                                                        <i class="fa fa-file pull-left fa-2x"></i>
                                                        <div class="media-body">
                                                            <div><a href="" class="strong text-regular">Contract.pdf</a></div>
                                                            <span>244 KB</span>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-separator-h box"></div>

                                            <div class="innerAll border-bottom inner-2x">
                                                <div class="media innerB">
                                                    <img src="{{ url('resources/assets/images/people/80/3.jpg') }}" alt="" width="50" class="pull-left" />
                                                    <div class="media-body innerT half">

                                                        <small class="text-muted pull-right">28 October 2013</small>

                                                        <h5 class="text-muted-darker">Yun Ragna <span class="text-weight-regular">(yun@mail.com)</span></h5>
                                                        <h5 class="text-muted-dark text-weight-normal">To: MosaicPro</h5>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <h4 class="innerT margin-none"><i class="fa fa-fw fa-circle-o text-success"></i> Web Application Inquiry</h4>
                                            </div>
                                            <div class="innerAll">
                                                <div class="innerAll">
                                                    <p>Hi Adrian,</p>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, libero corporis ipsam voluptatibus suscipit eos expedita sapiente omnis voluptatum ea! Culpa, vitae eaque quis modi voluptatum quisquam ullam. Modi, tempora!</p>
                                                    <p class="text-muted margin-none">Yun Ragna </br>Marketing Manager @ company.biz</br>www.company.biz</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col 2 -->
                </div>
            </div>
        </div>
    </div>
@stop