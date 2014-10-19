function CategoryEntity(datas){
    this._old = {id:null, name:null, slug:null};
    this._new = {id:null, name:null, slug:null};
    for(var p in datas){
        if(this._old.hasOwnProperty(p)){
            this._old[p] = angular.copy(datas[p]);
        }
    }
    this._new = angular.copy(this._old);
    this.isNew = this._new.id === null;
}

function Categories($http,configs){
    this.initialCats = [];
    this.http = $http;
    this.configs = configs;
    this.entities = [];
    this.categories = [];

}

Categories.prototype.getBaseUrl = function(){
    if(this.baseUrl === undefined){
        this.baseUrl = this.configs.urls.base + this.configs.urls.categories.base;
    }
    return this.baseUrl;
};

Categories.prototype.initialize = function(cats){
    this.initialCats = angular.copy(cats);
    this.init();
};

Categories.prototype.init = function(){
    var self = this;
    this.initialCats.forEach(function(el){
        var entity = angular.copy(el);

        self.$save(entity);
    });
};

Categories.prototype.all = function(){
    return this.categories;
};

Categories.prototype.save = function(entity, successCb, errorCb){
    var url, promise;
    if(!entity.isNew){
        url = this.getBaseUrl() + this.configs.urls.categories.update;
        promise = this.http.put(url, entity._new).success(successCb).error(errorCb);
    } else {
        url = this.getBaseUrl() + this.configs.urls.categories.save;
        promise = this.http.post(url, entity._new).success(successCb).error(errorCb);
    }
    return promise;
};

Categories.prototype.$save = function(entity){
    entity.isEdited = false;
    this.entities.push(new CategoryEntity(entity));
    this.categories.push(entity);
    return entity;
};

Categories.prototype.$update = function(entity, nValues){
    for(var p in nValues){
        if(entity._new.hasOwnProperty(p)){
            entity._new[p] = nValues[p];
        }
    }
    entity._old = angular.copy(entity._new);
    this.categories.forEach(function(el){
        if(el.id == entity._old.id){
            for(var p in entity._old){
                if(el.hasOwnProperty(p)){
                    el[p] = angular.copy(entity._old[p]);
                }
            }
        }
    });
};

Categories.prototype.$rollback = function(entity){
    entity._new = angular.copy(entity._old);
    this.categories.forEach(function(el){
        if(el.id == entity._old.id){
            console.log(el);
            for(var p in entity._old){
                if(el.hasOwnProperty(p)){
                    el[p] = angular.copy(entity._old[p]);
                }
            }
        }
    });
};

Categories.prototype.$delete = function(){

};

Categories.prototype.delete = function(){

};

Categories.prototype.$get = function(id){
    var entity;
    this.entities.forEach(function(el){
        if(el._new.id == id){
            entity = el;
        }
    });
    return entity;
};

Categories.prototype.$getCategory = function(id){
  var category;
    this.categories.forEach(function(el,i){
        if(el.id == id){
            category = el;
        }
    });
    return category;
};
