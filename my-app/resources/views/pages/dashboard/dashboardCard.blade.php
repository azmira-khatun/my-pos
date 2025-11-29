@extends('master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                {{-- 1. Today's Orders Card --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>15</h3>
                            <p>Today's Orders</p>
                        </div>
                        <div class="icon"><i class="ion ion-bag"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                {{-- 2. Today's Sales Card --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>৳500</h3>
                            <p>Today's Sales</p>
                        </div>
                        <div class="icon"><i class="ion ion-stats-bars"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                {{-- 3. Total Products Card --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>125</h3>
                            <p>Total Products</p>
                        </div>
                        <div class="icon"><i class="fas fa-boxes"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                {{-- 4. Low Stock Card --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>8</h3>
                            <p>Low Stock</p>
                        </div>
                        <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                        {{-- Last 7 Days Sales Card (Small Size: 25% width) --}}
                        <div class="col-lg-3 col-6">
                            <div class="small-box card-info">
                                <div class="inner">
                                    <h3>42K</h3> {{-- Static data for display --}}
                                    <p>Last 7 Days Sales</p>
                                </div>
                                <div class="icon"><i class="fas fa-chart-bar"></i></div>
                                <a href="#" class="small-box-footer">View Chart <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        {{-- Top Selling Products Card (Small Size: 25% width) --}}
                        <div class="col-lg-3 col-6">
                            <div class="small-box card-danger">
                                <div class="inner">
                                    <h3>A, B, C</h3> {{-- Showing top 3 products --}}
                                    <p>Top Selling Products</p>
                                </div>
                                <div class="icon"><i class="fas fa-chart-pie"></i></div>
                                <a href="#" class="small-box-footer">View Chart <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div> -->



            <div class="row">
                <section class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Sales</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Static Rows (Hardcoded) --}}
                                    <tr>
                                        <td>1001</td>
                                        <td>Oct 20, 2025</td>
                                        <td>Mr. Ali</td>
                                        <td>৳1,200.00</td>
                                        <td><span class="badge bg-success">Delivered</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-center"><a href="#">View All Sales</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection