config =
  local:
    mode: 'local'
    port: 3000
  test:
    mode: 'test'
    port: 3001
  production:
    mode: 'production'
    port: 3002

module.exports = ( mode ) ->
  config[ mode || process.env.ENV || process.argv[ 2 ] || 'local' ]
