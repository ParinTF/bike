@extends('layouts.master')

@section('title')
    BikeShop | อุปกรณ์จักรยาน, อะไหล่, ชุดแข่ง และอุปกรณ์ตกแต่ง
@endsection

@section('content')
    <div class="row" ng-app="app" ng-controller="ctrl">
        <!-- แสดงหมวดหมู่ -->
        <div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-item" ng-repeat="c in categories">
                    @{{ c.name }}
                </a>
            </div>
        </div>

        <!-- แสดงสินค้า -->
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-3" ng-repeat="p in products track by p.id">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4><a href="#">@{{ p.name }}</a></h4>
                            <div class="form-group">
                                <div>คงเหลือ: @{{ p.stock_qty }}</div>
                                <div>ราคา <strong>@{{ p.price | number: 2 }}</strong> บาท</div>
                            </div>
                            <a href="#" class="btn btn-success btn-block">
                                <i class="fa fa-shopping-cart"></i> หยิบใส่ตะกร้า
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            var app = angular.module('app', []).config(function($interpolateProvider) {
                $interpolateProvider.startSymbol('@{{').endSymbol('}}');
            });

            app.service('productService', function($http) {
                this.getProductList = function() {
                    return $http.get('/api/product');
                };
                this.getCategoryList = function() {
                    return $http.get('/api/category');
                };
            });

            app.controller('ctrl', function($scope, productService) {
                // โหลด categories
                productService.getCategoryList().then(function(res) {
                    // --- แก้ไขกลับมาเป็นแบบเดิม ---
                    // ตรวจสอบว่ามี key 'categories' ที่เป็น Array หรือไม่
                    if (res.data && res.data.ok && Array.isArray(res.data.categories)) {
                        $scope.categories = res.data.categories;
                    }
                });

                // โหลด products
                productService.getProductList().then(function(res) {
                    // --- แก้ไขกลับมาเป็นแบบเดิม ---
                    // ตรวจสอบว่ามี key 'products' ที่เป็น Array หรือไม่
                    if (res.data && res.data.ok && Array.isArray(res.data.products)) {
                        $scope.products = res.data.products;
                    }
                });
            });
        })();
    </script>
@endsection