@app.directive 'equalTo', ->
  require: 'ngModel'
  scope:
    to:      "=equalTo"
    current: "=ngModel"

  link: ( scope, element, attrs, ngModel ) ->
    ngModel.$validators.equalTo = ( modelValue ) ->
      modelValue is scope.to

    scope.$watch 'current', (newVal, oldVal) ->
      ngModel.$validate()
