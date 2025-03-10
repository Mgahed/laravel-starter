<?php

namespace Mgahed\LaravelStarter\Resources\Settings\Translation;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TranslationResource extends JsonResource {

	public function toArray($request) {

		return [
			'id' => $this->id,
			'text' => str_replace('_','-',Str::snake($this->translation_key)),
			'children' => @$this->child_count == 0 ? false : true
		];
	}
}
