<div class="profile-listing-row">
	<div class="profile-listing-cell" >
		<a href="profiles/{{$id}}"><img class="profile-listing-photo" id="profile-listing-photo-{{$id}}" src="{{$photo}}" alt="{{$alt}}" /></a>
	</div>
	<div class="profile-listing-cell" id="profile-listing-name-{{$id}}">
		<a href="profiles/{{$id}}" class="profile-listing-edit-link" >{{$profile_name}}</a>
	</div>
	<div class="profile-listing-cell">
		{{$visible}}
	</div>
</div>
