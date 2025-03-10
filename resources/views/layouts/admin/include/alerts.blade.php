@if(session("success") != null)
	<div class="rounded px-10 pb-0 d-flex flex-column">
		<div class="alert alert-dismissible bg-light-success border d-flex flex-column flex-sm-row p-5 mb-10 ">
			<i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span
					class="path2"></span></i>
			<div class="d-flex flex-column">
				<h4 class="mb-1 text-dark">{{__("starter.Success")}}</h4>
				<span>
             {{session("success")}}
            </span>
			</div>
			<button type="button"
					class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
					data-bs-dismiss="alert">
				<i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
			</button>
		</div>
	</div>
@endif

@if(session("error") != null)
	<div class="rounded px-10 pb-0 d-flex flex-column">
		<div class="alert alert-dismissible alert-danger border d-flex align-items-center p-5">
			<i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span
					class="path2"></span></i>
			<div class="d-flex flex-column">
				<h4 class="mb-1 text-dark">{{__("starter.Error")}}</h4>
				<span>
						{{session("error")}}
            </span>
			</div>
			<button type="button"
					class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
					data-bs-dismiss="alert">
				<i class="ki-duotone ki-cross fs-1 text-light"><span class="path1"></span><span
						class="path2"></span></i>
			</button>
		</div>
	</div>
@endif
