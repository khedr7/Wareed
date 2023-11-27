<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\TermsPolicy;

class TermsPolicyService
{
    use ModelHelper;

    public function getAll()
    {
        return TermsPolicy::all();
    }

    public function find()
    {
        return TermsPolicy::first();
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

        $terms_policy = TermsPolicy::create($validatedData);

        DB::commit();

        return $terms_policy;
    }

    public function update($validatedData)
    {
        $terms_policy = TermsPolicy::first();

        DB::beginTransaction();

        if (isset($validatedData['terms_en']) || isset($validatedData['terms_ar'])) {
            $validatedData['terms'] = [
                'en' => $validatedData['terms_en'],
                'ar' => $validatedData['terms_ar'],
            ];
        } elseif(isset($validatedData['policy_en']) || isset($validatedData['policy_ar'])) {
            $validatedData['policy'] = [
                'en' => $validatedData['policy_en'],
                'ar' => $validatedData['policy_ar'],
            ];
        }
        if ($terms_policy) {
            $terms_policy->update($validatedData);
        } else {
            $terms_policy = TermsPolicy::create($validatedData);
        }

        DB::commit();

        return true;
    }

    public function delete($terms_policyId)
    {
        $terms_policy = $this->find($terms_policyId);

        DB::beginTransaction();

        $terms_policy->delete();

        DB::commit();

        return true;
    }
}
