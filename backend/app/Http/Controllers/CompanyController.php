<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $companies = Company::all();

        return $this->successResponse($companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request): JsonResponse
    {
        $data = $request->validated();

        $logo = $request->file('logo');
        if ($logo) {
            $logoPath = $logo->store('company', 'public');
            $data['logo_path'] = $logoPath;
        }

        $company = Company::create($data);

        return $this->successResponse($company);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company): JsonResponse
    {
        return $this->successResponse($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company): JsonResponse
    {
        $data = $request->validated();

        $logo = $request->file('logo');
        if ($logo) {
            $logoPath = $logo->store('company', 'public');
            $data['logo_path'] = $logoPath;
        }

        $updated = $company->update($data);

        if (!$updated) {
            return $this->errorResponse('Company could not be updated', 500);
        }

        return $this->successResponse($company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): JsonResponse
    {
        $deleted = $company->delete();

        if (!$deleted) {
            return $this->errorResponse('Company could not be deleted', 500);
        }

        return $this->successResponse();
    }
}
