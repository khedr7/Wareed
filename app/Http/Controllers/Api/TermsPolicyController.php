<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TermsPolicyResource;
use App\Services\TermsPolicyService;

class TermsPolicyController extends Controller
{
    public function __construct(private TermsPolicyService $terms_policyService)
    {
    }

    public function find()
    {
        $terms_policies = $this->terms_policyService->find();

        return $this->successResponse(
            $this->resource($terms_policies, TermsPolicyResource::class),
            'dataFetchedSuccessfully'
        );
    }
}
