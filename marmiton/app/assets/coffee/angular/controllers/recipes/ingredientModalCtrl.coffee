@app.controller 'ingredientModalCtrl', ( $scope, $modalInstance, ri, index, $timeout ) ->
  $scope.searchResult = null
  $scope.units        = $units
  $scope.index        = index

  $scope.isEdition = ri? ? true : false

  $scope.recipe_ingredient = ri || {}

  ingredients = new Bloodhound(
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote:
      url: '/ingredients/search/%QUERY'
      wildcard: '%QUERY'
  )

  ingredients.initialize()

  $scope.$watch 'searchResult.name', (newValue, oldValue) ->
    if newValue isnt oldValue and $scope.searchResult.name?.length > 0
      $scope.recipe_ingredient =
        ingredient_id: $scope.searchResult.id
        ingredient:
          name: $scope.searchResult.name

      $timeout ->
        angular.element('.unit_type').trigger('focus')
      , 100
  $scope.thOptions =
    highlight: true
    hint: true

  $scope.thData =
    displayKey: 'value'
    source: ingredients.ttAdapter()
    templates:
      suggestion: (ingredient) ->
        return "<p>#{ingredient.name}</p>"

  $scope.getUnits = ( unit_type ) ->
    unit_type = _( $units ).findWhere( unit_type: unit_type )
    if unit_type
      return unit_type.units

  $scope.add = ->
    $modalInstance.close( ri: $scope.recipe_ingredient, index: $scope.index )

  $scope.cancel = ->
    $modalInstance.dismiss 'cancel'
