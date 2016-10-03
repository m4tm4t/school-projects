this.app = angular.module('app', ['ui.router', 'siyfion.sfTypeahead', 'ui.bootstrap']);

this.app.config(function($stateProvider, $urlRouterProvider) {
  $urlRouterProvider.otherwise('/');
  return $stateProvider.state('home', {
    url: '/',
    controller: 'homeCtrl',
    templateProvider: function($stateParams, $templateCache, $timeout) {
      return $timeout(function() {
        return $templateCache.get('home');
      }, 40);
    }
  }).state('createRecipe', {
    url: '/recipes/add',
    controller: 'recipeCtrl',
    templateProvider: function($stateParams, $templateCache, $timeout) {
      return $timeout(function() {
        return $templateCache.get('addRecipe');
      }, 40);
    }
  }).state('editRecipe', {
    url: '/recipes/{recipeId:[0-9]{1,4}}/edit',
    controller: 'recipeCtrl',
    templateProvider: function($stateParams, $templateCache, $timeout) {
      return $timeout(function() {
        return $templateCache.get('editRecipe');
      }, 40);
    }
  }).state('showRecipe', {
    url: '/recipes/{recipeId:[0-9]{1,4}}',
    controller: 'showRecipeCtrl',
    templateProvider: function($stateParams, $templateCache, $timeout) {
      return $timeout(function() {
        return $templateCache.get('showRecipe');
      }, 40);
    }
  }).state('searchRecipe', {
    url: '/recipes/search/{term}',
    controller: 'searchRecipeCtrl',
    templateProvider: function($stateParams, $templateCache, $timeout) {
      return $timeout(function() {
        return $templateCache.get('searchRecipe');
      }, 40);
    }
  });
});

this.app.run(function($rootScope, $state, $stateParams) {
  var getUnit, getUnitType;
  $rootScope.$state = $state;
  $rootScope.$stateParams = $stateParams;
  getUnitType = function(id) {
    return _($units).findWhere({
      unit_type: id
    });
  };
  getUnit = function(ut, id) {
    return _.invert(ut.units)[id];
  };
  return $rootScope.humanizeUnits = function(ri) {
    var unit, ut, val;
    ut = getUnitType(ri.unit_type);
    unit = getUnit(ut, ri.unit);
    val = ri.unit_value;
    return "" + val + (unit || '');
  };
});

this.app.controller('appCtrl', function($scope) {});

this.app.controller('homeCtrl', function($rootScope, $scope, $http, $templateCache) {
  $http.get('/recipes').success(function(data) {
    return $scope.recipes = data;
  });
  return $scope.foo = function() {
    return $rootScope.$state.go('searchRecipe', {
      term: $scope.searchTerm
    });
  };
});

this.app.controller('modalCommentCtrl', function($scope, $modalInstance, $http, recipe) {
  $scope.comment = {
    username: "",
    body: "",
    note: 0
  };
  $scope.comment.recipe_id = recipe.id;
  $scope.add = function() {
    return $http.post("/comments", $scope.comment).success(function(data) {
      return $modalInstance.close(data);
    });
  };
  return $scope.cancel = function() {
    return $modalInstance.dismiss('cancel');
  };
});





this.app.controller('ingredientModalCtrl', function($scope, $modalInstance, ri, index, $timeout) {
  var ingredients, ref;
  $scope.searchResult = null;
  $scope.units = $units;
  $scope.index = index;
  $scope.isEdition = (ref = ri != null) != null ? ref : {
    "true": false
  };
  $scope.recipe_ingredient = ri || {};
  ingredients = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: '/ingredients/search/%QUERY',
      wildcard: '%QUERY'
    }
  });
  ingredients.initialize();
  $scope.$watch('searchResult.name', function(newValue, oldValue) {
    var ref1;
    if (newValue !== oldValue && ((ref1 = $scope.searchResult.name) != null ? ref1.length : void 0) > 0) {
      $scope.recipe_ingredient = {
        ingredient_id: $scope.searchResult.id,
        ingredient: {
          name: $scope.searchResult.name
        }
      };
      return $timeout(function() {
        return angular.element('.unit_type').trigger('focus');
      }, 100);
    }
  });
  $scope.thOptions = {
    highlight: true,
    hint: true
  };
  $scope.thData = {
    displayKey: 'value',
    source: ingredients.ttAdapter(),
    templates: {
      suggestion: function(ingredient) {
        return "<p>" + ingredient.name + "</p>";
      }
    }
  };
  $scope.getUnits = function(unit_type) {
    unit_type = _($units).findWhere({
      unit_type: unit_type
    });
    if (unit_type) {
      return unit_type.units;
    }
  };
  $scope.add = function() {
    return $modalInstance.close({
      ri: $scope.recipe_ingredient,
      index: $scope.index
    });
  };
  return $scope.cancel = function() {
    return $modalInstance.dismiss('cancel');
  };
});

this.app.controller('recipeCtrl', function($rootScope, $scope, $q, $http, $timeout, $modal, $templateCache) {
  var $step, recipeId;
  $step = {
    title: "",
    body: "",
    duration: ""
  };
  $scope.similar = false;
  $scope.addStep = function() {
    return $scope.recipe.steps.push(angular.copy($step));
  };
  recipeId = $rootScope.$stateParams.recipeId;
  if (recipeId) {
    $http.get("/recipes/" + recipeId).success(function(data) {
      $scope.recipe = data;
      return $scope.recipe.image = "/recipe-" + recipeId + ".jpg";
    });
  } else {
    $scope.recipe = {
      recipe_ingredients: [],
      steps: []
    };
    $scope.addStep();
  }
  $http.get("/categories").success(function(data) {
    return $scope.categories = data;
  });
  $scope.testExists = function() {
    return $http.post("/recipes/check_exists", $scope.recipe).success(function(data) {
      return $scope.similar = data.result;
    });
  };
  $scope.addIngredient = function(ri, index) {
    var modalInstance;
    modalInstance = $modal.open({
      animation: true,
      template: $templateCache.get('add_ingredient.html'),
      controller: 'ingredientModalCtrl',
      resolve: {
        ri: function() {
          return ri || null;
        },
        index: function() {
          return index;
        }
      }
    });
    modalInstance.opened.then(function() {
      return $timeout(function() {
        return angular.element('.typeahead').trigger('focus');
      });
    });
    return modalInstance.result.then(function(result) {
      if (result.index != null) {
        return $scope.recipe.recipe_ingredients[result.index] = result.ri;
      } else {
        $scope.recipe.recipe_ingredients.push(result.ri);
        return $scope.testExists();
      }
    });
  };
  $scope.editIngredient = function($index) {
    return $scope.addIngredient($scope.recipe.recipe_ingredients[$index], $index);
  };
  $scope.handleImage = function(img) {
    var fileReader;
    fileReader = new FileReader;
    fileReader.readAsDataURL(img.files[0]);
    return fileReader.onload = function(e) {
      return $timeout(function() {
        return $scope.recipe.image = e.target.result;
      });
    };
  };
  $scope.remove = function($ingredient) {
    return $scope.recipe.recipe_ingredients.splice($ingredient, 1);
  };
  $scope.removeStep = function($step) {
    return $scope.recipe.steps.splice($step, 1);
  };
  return $scope.save = function() {
    var ref;
    if ((ref = $scope.recipe) != null ? ref.id : void 0) {
      return $http.put("/recipes/" + $scope.recipe.id, $scope.recipe).then(function(response) {
        var ref1;
        if (((ref1 = response.data) != null ? ref1.id : void 0) != null) {
          return $rootScope.$state.go('editRecipe', {
            recipeId: response.data.id
          });
        }
      }).then(function(response) {
        return alert(response);
      });
    } else {
      return $http.post('/recipes', $scope.recipe).then(function(response) {
        var ref1;
        if (((ref1 = response.data) != null ? ref1.id : void 0) != null) {
          return $rootScope.$state.go('showRecipe', {
            recipeId: response.data.id
          });
        } else {
          return alert('Votre recette est trop similaire à une autre, enregistrement impossible');
        }
      }).then(function(response) {
        return alert(response);
      });
    }
  };
});

this.app.controller('searchRecipeCtrl', function($scope, $rootScope, $http, $modal, $templateCache) {
  var ingredients;
  $scope.searchTerm = $rootScope.$stateParams.term;
  $scope.ingredients = [];
  $scope.foo = function() {
    $scope.ingredients = [];
    return $rootScope.$state.go('searchRecipe', {
      term: $scope.searchTerm
    });
  };
  $http.get("/recipes/search/" + $scope.searchTerm).success(function(data) {
    return $scope.recipes = data;
  });
  ingredients = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: '/ingredients/search/%QUERY',
      wildcard: '%QUERY'
    }
  });
  ingredients.initialize();
  $scope.searchRecipeWithIngredients = function() {
    var ingredientIds;
    ingredientIds = _($scope.ingredients).map(function(i) {
      return i.id;
    });
    return $http.get("/recipes/search2/" + (ingredientIds.join(','))).success(function(data) {
      return $scope.recipes = data;
    });
  };
  $scope.removeIngredient = function($index) {
    $scope.ingredients.splice($index, 1);
    $scope.recipes = [];
    return $scope.searchRecipeWithIngredients();
  };
  $scope.ingToS = function() {
    var names;
    names = _($scope.ingredients).map(function(i) {
      return i.name;
    });
    return names.join(',');
  };
  $scope.$watch('searchResult.name', function(newValue, oldValue) {
    var ref;
    if (newValue !== oldValue && ((ref = $scope.searchResult.name) != null ? ref.length : void 0) > 0) {
      $scope.searchTerm = null;
      if ($scope.searchResult.id) {
        $scope.ingredients.push($scope.searchResult);
      }
      return $scope.searchRecipeWithIngredients();
    }
  });
  $scope.thOptions = {
    highlight: true,
    hint: true
  };
  return $scope.thData = {
    displayKey: 'value',
    source: ingredients.ttAdapter(),
    templates: {
      suggestion: function(ingredient) {
        if (ingredient.id) {
          return "<p>" + ingredient.name + "</p>";
        } else {
          return "<p>Aucun ingrédient ne correspond à votre recherche</p>";
        }
      }
    }
  };
});

this.app.controller('showRecipeCtrl', function($scope, $rootScope, $http, $modal, $templateCache) {
  $http.get("/recipes/" + $rootScope.$stateParams.recipeId).success(function(data) {
    return $scope.recipe = data;
  }).error(function(data) {
    return console.log(data);
  });
  return $scope.addComment = function() {
    var modalInstance;
    modalInstance = $modal.open({
      animation: true,
      template: $templateCache.get('add_comment.html'),
      controller: 'modalCommentCtrl',
      resolve: {
        recipe: function() {
          return $scope.recipe;
        }
      }
    });
    return modalInstance.result.then(function(result) {
      return $scope.recipe.comments.push(result);
    });
  };
});
