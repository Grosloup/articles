var app = angular.module("UpdatePostApp", []);
app.config([
    "$interpolateProvider",
    "$httpProvider",
    function($intepolateProvider, $httpProvider){
        $intepolateProvider.startSymbol("{$").endSymbol("$}");
        $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
    }
]);

app.value(
    "configs",
    {
        urls: {
            "base": "/api",
            categories: {
                "base":"/post/categories",
                "save": "/",
                "update": "/",
                "get": "/",
                "getAll": "/",
                "delete": "/"
            },
            tags: {
                "base": "/post/tags",
                "save": "/",
                "update": "/",
                "get": "/",
                "getAll": "/",
                "delete": "/"
            }
        }
    }
);

app.factory("$postData", ["$window",function($window){
    return {
        category: $window.postInitialCategory || {},
        tags: $window.postInitialTags
    };
}]);

app.factory("$categories", ["$http","configs",function($http,configs){
    return new Categories($http,configs);
}]);

app.factory("$tags", ["$http","configs",function($http,configs){
    return new Tags($http,configs);
}]);

app.controller("TagsController", ["$scope","$window","$tags","$postData",function($scope,$window,$tags,$postData){
    $tags.initialize($window.initTags || []);
    $scope.tags = $tags.all();
    $scope.new_tag_name = "";
    $scope.tag_is_saving = false;

    function refreshTags(){
        $scope.post_tags = [];
        $postData.tags.forEach(function(el){
            $scope.addTag(el);
        });

    }


    $scope.addTag = function(tag){
        $scope.post_tags.push(tag);

        var idx;
        $scope.tags.forEach(function(el,i){
            if(el.id == tag.id){
                idx = i;
            }
        });
        $scope.tags.splice(idx, 1);
    };

    $scope.removeTag = function(tag){

        $scope.tags.push(tag);
        var idx;
        $scope.post_tags.forEach(function(el,i){
            if(el.id == tag.id){
                idx = i;
            }
        });
        $scope.post_tags.splice(idx, 1);
    };

    $scope.newTag = function(){
        if($scope.new_tag_name == ""){
            return;
        }
        $scope.tag_is_saving = true;
        var entity = new TagEntity({name: $scope.new_tag_name});
        $scope.new_tag_name = "";
        $tags.save(entity,
            function(data, status, headers, config){
                if(data.error == false){
                    var t = $tags.$save(data.tag);
                    $scope.addTag(t);
                }
                $scope.tag_is_saving = false;
            },
            function(data, status, headers, config){
                // server error status code 400 500
            }
        );

    };

    $scope.$watchCollection("post_tags", function(value){
        $postData.tags = value;

    }, true);
    refreshTags();
    $scope.$watchCollection("post_tags", function(value){
        $postData.tags = value;

    }, true);
}]);


app.controller("CategoriesController", ["$scope","$window","$categories","$postData",function($scope,$window,$categories,$postData){
    $scope.cat_is_saving = false;
    $categories.initialize($window.initCategories || []);
    $scope.categories = $categories.all();
    function refresh(){
        $scope.cat_selected = $categories.$getCategory($postData.category.id);
    }
    refresh();
    $scope.$watch("cat_selected", function(value){
        $postData.category = value;
    });

    $scope.newCatForPost = function(){
        if($scope.new_cat_name == ""){
            return;
        }
        $scope.cat_is_saving = true;
        var entity = new CategoryEntity({name: $scope.new_cat_name});
        $scope.new_cat_name = "";
        $categories.save(entity, function(data, status, headers, config){
            if(data.error == false){

                $postData.category = $categories.$save(data.cat);
                refresh();
                $scope.cat_is_saving = false;
            }
        }, function(data, status, headers, config){
            // server error status code 400 500
        });
    };
}]);

app.controller("TargetsController", ["$scope","$window","$postData","filterFilter",function($scope,$window,$postData,filterFilter){
    $scope.targets = $window.postTargets || [];
    $scope.$watch("targets", function(value){
        console.log(value);
        $postData.targets = filterFilter($scope.targets, {checked: true});
        console.log($postData.targets);
    }, true);
}]);

app.controller("PostController", ["$scope","$window","$postData",function($scope,$window,$postData){
$scope.datas = $postData;

}]);


