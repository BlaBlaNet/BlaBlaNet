<div class="generic-content-wrapper-styled">
<h3>{{$title}}</h3>
<p></p>
<p>{{$description}}</p>
{{if $version}}
<p>{{$version}}{{if $commit}}+{{$commit}}{{/if}}</p>
{{/if}}
{{if $tag}}
<p>{{$tag_txt}} {{$tag}}</p>
{{/if}}
{{if $polled}}
<p>{{$polled}} {{$lastpoll}}</p>
{{/if}}
<p>{{$load_average}} {{$loadavg_all}}</p>
<p>{{$web_location}}</p>
<p>{{$visit}}</p>
<p>{{$bug_text}} <a href="{{$bug_link_url}}">{{$bug_link_text}}</a></p>
<p>{{$adminlabel}}</p>
<p>{{$admininfo}}</p>
<p>{{$contact}}</p>
<p>{{$plugins_text}}</p>
{{if $plugins_list}}
   <div style="margin-left: 25px; margin-right: 25px;">{{$plugins_list}}</div>
{{/if}}
<p>{{$donate}}</p>
</div>
