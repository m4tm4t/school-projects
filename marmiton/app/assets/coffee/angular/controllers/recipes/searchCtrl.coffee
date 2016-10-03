@app.controller 'searchRecipeCtrl', ( $scope, $rootScope, $http, $modal, $templateCache ) ->

  $scope.searchTerm  = $rootScope.$stateParams.term
  $scope.ingredients = []

  $scope.foo = ->
    $scope.ingredients = []
    $rootScope.$state.go 'searchRecipe', term: $scope.searchTerm

  $http.get "/recipes/search/#{$scope.searchTerm}"
    .success (data) ->
      $scope.recipes = data

  ingredients = new Bloodhound(
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote:
      url: '/ingredients/search/%QUERY'
      wildcard: '%QUERY'
  )

  ingredients.initialize()

  $scope.searchRecipeWithIngredients = ->
    ingredientIds = _( $scope.ingredients ).map (i) -> return i.id
    $http.get "/recipes/search2/#{ingredientIds.join(',')}"
      .success (data) ->
        $scope.recipes = data

  $scope.removeIngredient = ($index) ->
    $scope.ingredients.splice($index, 1)
    $scope.recipes = []
    $scope.searchRecipeWithIngredients()

  $scope.ingToS = ->
    names = _( $scope.ingredients ).map (i) ->
      return i.name
    names.join(',')

  $scope.$watch 'searchResult.name', (newValue, oldValue) ->
    if newValue isnt oldValue and $scope.searchResult.name?.length > 0
      $scope.searchTerm = null
      $scope.ingredients.push $scope.searchResult if $scope.searchResult.id
      $scope.searchRecipeWithIngredients()

  $scope.thOptions =
    highlight: true
    hint: true

  $scope.thData =
    displayKey: 'value'
    source: ingredients.ttAdapter()
    templates:
      suggestion: (ingredient) ->
        if ingredient.id
          return "<p>#{ingredient.name}</p>"
        else
          return "<p>Aucun ingrédient ne correspond à votre recherche</p>"
