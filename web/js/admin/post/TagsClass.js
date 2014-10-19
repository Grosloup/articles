function TagEntity(datas){
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

function Tags($http,configs){
    this.initialTags = [];
    this.http = $http;
    this.configs = configs;
    this.tags = [];
    this.entities = [];
}

Tags.prototype.getBaseUrl = function(){
    if(this.baseUrl === undefined){
        this.baseUrl = this.configs.urls.base + this.configs.urls.tags.base;
    }
    return this.baseUrl;
};

Tags.prototype.init = function(){
    var self = this;
    this.initialTags.forEach(function(entity){
        self.$save(angular.copy(entity));
    });
};

Tags.prototype.initialize = function(tags){
    this.initialTags = angular.copy(tags);
    this.init();
};

Tags.prototype.save = function(entity, successCb, errorCb){
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

Tags.prototype.$save = function(entity){
    this.entities.push(new TagEntity(entity));
    this.tags.push(entity);
    return entity;
};

Tags.prototype.all = function(){
    return this.tags;
};
