<XML>
 <post><profile>
  <diaspora_handle>{{$handle}}</diaspora_handle>
  <first_name>{{$first}}</first_name>
  <last_name>{{$last}}</last_name>
  <image_url>{{$large}}</image_url>
  <image_url_medium>{{$medium}}</image_url_medium>
  <image_url_small>{{$small}}</image_url_small>
  {{if $dob}}<birthday>{{$dob}}</birthday>{{/if}}
  <gender>{{$gender}}</gender>
  <bio>{{$about}}</bio>
  <location>{{$location}}</location>
  <searchable>{{$searchable}}</searchable>
  <nsfw>{{$nsfw}}</nsfw>
  <tag_string>{{$tags}}</tag_string>
 </profile></post>
</XML>
