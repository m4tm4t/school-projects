@app = angular.module 'app',
[
  'ui.router'
  'siyfion.sfTypeahead'
  'ui.bootstrap'
]

@app.config ( $stateProvider, $urlRouterProvider ) ->
  $urlRouterProvider.otherwise( '/' )
  $stateProvider
    .state( 'home',
      url: '/'
      controller: 'homeCtrl'
      templateProvider: ( $stateParams, $templateCache, $timeout ) ->
        $timeout ->
          return $templateCache.get( 'home' )
        , 40
    )
    .state( 'createRecipe',
      url: '/recipes/add'
      controller: 'recipeCtrl'
      templateProvider: ( $stateParams, $templateCache, $timeout ) ->
        $timeout ->
          return $templateCache.get( 'addRecipe' )
        , 40
    )
    .state( 'editRecipe',
      url: '/recipes/{recipeId:[0-9]{1,4}}/edit'
      controller: 'recipeCtrl'

      templateProvider: ( $stateParams, $templateCache, $timeout ) ->
        $timeout ->
          return $templateCache.get( 'editRecipe' )
        , 40
    )
    .state( 'showRecipe',
      url: '/recipes/{recipeId:[0-9]{1,4}}'
      controller: 'showRecipeCtrl'
      templateProvider: ( $stateParams, $templateCache, $timeout ) ->
        $timeout ->
          return $templateCache.get( 'showRecipe' )
        , 40
    )
    .state( 'searchRecipe',
      url: '/recipes/search/{term}'
      controller: 'searchRecipeCtrl'
      templateProvider: ( $stateParams, $templateCache, $timeout ) ->
        $timeout ->
          return $templateCache.get( 'searchRecipe' )
        , 40
    )
@app.run ( $rootScope, $state, $stateParams ) ->
  $rootScope.$state       = $state
  $rootScope.$stateParams = $stateParams

  getUnitType = (id) ->
    _( $units ).findWhere( unit_type: id )

  getUnit = (ut, id) ->
    _.invert(ut.units)[id]

  $rootScope.humanizeUnits = (ri) ->
    ut   = getUnitType(ri.unit_type)
    unit = getUnit(ut, ri.unit)
    val  = ri.unit_value
    return "#{val}#{unit || ''}"
