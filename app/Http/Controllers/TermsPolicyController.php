<?php

namespace App\Http\Controllers;

use App\Http\Requests\TermsPolicyRequest;
use App\Http\Resources\TermsPolicyResource;
use App\Services\TermsPolicyService;

class TermsPolicyController extends Controller
{
    public function __construct(private TermsPolicyService $terms_policyService)
    {
    }

    public function getAll()
    {
        $terms_policies = $this->terms_policyService->getAll();
        return $this->successResponse(
            $this->resource($terms_policies, TermsPolicyResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function find()
    {
        $terms_policy = $this->terms_policyService->find();

        return view('terms.edit', compact('terms_policy'));
    }

    public function editTerms()
    {
        $terms_policy = $this->terms_policyService->find();

        return view('terms.edit', compact('terms_policy'));
    }

    public function editPolicy()
    {
        $terms_policy = $this->terms_policyService->find();

        return view('terms.policy', compact('terms_policy'));
    }

    public function create(TermsPolicyRequest $request)
    {
        $validatedData = $request->validated();
        $terms_policy = $this->terms_policyService->create($validatedData);

        return $this->successResponse(
            $this->resource($terms_policy, TermsPolicyResource::class),
            'dataAddedSuccessfully'
        );
    }

    public function update(TermsPolicyRequest $request)
    {
        $validatedData = $request->validated();
        $this->terms_policyService->update($validatedData);

        if (isset($validatedData['terms_en']) || isset($validatedData['terms_ar'])) {
            return redirect('terms')->with('success', __('messages.dataUpdatedSuccessfully'));
        } elseif (isset($validatedData['policy_en']) || isset($validatedData['policy_ar'])) {
            return redirect('policy')->with('success', __('messages.dataUpdatedSuccessfully'));
        }
    }

    public function delete($terms_policyId)
    {
        $this->terms_policyService->delete($terms_policyId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }
}
