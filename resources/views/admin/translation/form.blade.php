<div class="card shadow-sm">
    <div class="card-header collapsible cursor-pointer rotate"
         data-bs-toggle="collapse"
         data-bs-target="#kt_docs_card_collapsible_add">
        <h3 class="card-title"> {{__("admin.settings.translations.Add custom key")}}</h3>
        <div class="card-toolbar rotate-180">
            <span class="svg-icon svg-icon-1">
                ...
            </span>
        </div>
    </div>
    <div id="kt_docs_card_collapsible_add" class="collapse">
        <div class="card-body">
            <form class="kt-form" method="POST" action="{{route('translations.addCustomKey')}}" name="CustomKeysForm"
                  id="CustomKeysForm">
                @csrf
                <input type="hidden" name="customKeys" value="1">
                <div class="input-group">
                    <button type="submit" class="btn btn-label btn-label-brand btn-bold">
                        <em class="fas fa-key"></em> {{__("admin.settings.translations.Add custom key")}}
                    </button>
                    <input dir="ltr" type="text" name="customKey" id="customKey" maxlength="255" value=""
                           class="form-control" aria-describedby="" placeholder="">

                </div>
                <span class="form-text text-muted">{{__("admin.settings.translations.Add custom key")}}</span>
            </form>
        </div>
    </div>
</div>
