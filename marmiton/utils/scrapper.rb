require 'nokogiri'
require 'open-uri'
require 'json'

#
# Extract ingredients from marmiton.org
#

@uri = "http://www.marmiton.org/recettes/recettes-index.aspx?letter="
@ingredients = []

('A'..'Z').each do |letter|
  doc = Nokogiri::HTML( open( @uri + letter ) )
  ingredients = doc.css('ul.m-lsting-ing > li > a')
  ingredients.each { |i| @ingredients << i.text }
end

File.open('ingredients.json', 'w') do |file|
  file.write @ingredients.to_json
end
