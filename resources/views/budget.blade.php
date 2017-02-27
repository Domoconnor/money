@extends('spark::layouts.app')

@section('content')
	<home :user="user" inline-template>
		<div class="container-fluid">
			<!-- Application Dashboard -->
			<div class="row">
				<div class="col-md-2">
					<account-list></account-list>
				</div>
				<div class="col-md-8 ">
					<budget-list></budget-list>
				</div>
			</div>
		</div>
	</home>
@endsection
