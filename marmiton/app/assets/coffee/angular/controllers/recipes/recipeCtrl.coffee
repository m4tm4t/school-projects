@app.controller 'recipeCtrl', ( $rootScope, $scope, $q, $http, $timeout, $modal, $templateCache ) ->

  $step =
    title:    ""
    body:     ""
    duration: ""

  $scope.similar = false

  $scope.addStep = ->
    $scope.recipe.steps.push angular.copy($step)

  recipeId = $rootScope.$stateParams.recipeId
  if recipeId
    $http.get "/recipes/#{recipeId}"
      .success (data) ->
        $scope.recipe = data
        $scope.recipe.image  = "/recipe-#{recipeId}.jpg"
  else
    $scope.recipe =
      recipe_ingredients: []
      steps:              []
    $scope.addStep()

  $http.get "/categories"
    .success (data) ->
      $scope.categories = data

  $scope.testExists = ->
    $http.post("/recipes/check_exists", $scope.recipe)
      .success (data) ->
        $scope.similar = data.result

  $scope.addIngredient = ( ri, index ) ->
    modalInstance = $modal.open(
      animation:  true
      template:   $templateCache.get( 'add_ingredient.html' )
      controller: 'ingredientModalCtrl'
      resolve:
        ri:    -> ri    || null
        index: -> index
    )
    modalInstance.opened.then ->
      $timeout ->
        angular.element('.typeahead').trigger('focus');
    modalInstance.result.then ( result ) ->
      if result.index?
        $scope.recipe.recipe_ingredients[ result.index ] = result.ri
      else
        $scope.recipe.recipe_ingredients.push result.ri
        $scope.testExists()

  $scope.editIngredient = ( $index ) ->
    $scope.addIngredient( $scope.recipe.recipe_ingredients[$index], $index )

  $scope.handleImage = (img) ->
    fileReader = new FileReader
    fileReader.readAsDataURL img.files[0]

    fileReader.onload = (e) ->
      $timeout ->
        $scope.recipe.image = e.target.result

  $scope.remove = ($ingredient) ->
    $scope.recipe.recipe_ingredients.splice($ingredient, 1)

  $scope.removeStep = ($step) ->
    $scope.recipe.steps.splice($step, 1)

  $scope.save = ->

    if $scope.recipe?.id
      $http.put( "/recipes/#{$scope.recipe.id}", $scope.recipe )
        .then (response) ->
          if response.data?.id?
            $rootScope.$state.go('editRecipe', recipeId: response.data.id)
        .then (response) ->
          alert response
    else
      $http.post( '/recipes', $scope.recipe )
        .then (response) ->
          if response.data?.id?
            $rootScope.$state.go('showRecipe', recipeId: response.data.id)
          else
            alert 'Votre recette est trop similaire à une autre, enregistrement impossible'
        .then (response) ->
          alert response
