<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function show()
    {
        if (! $company = Auth::user()->company()->first()) {
            return response()->json(['message' => 'This user does not own a company'], 404);
        }

        return new CompanyResource($company);
    }

    public function update(UpdateCompanyRequest $request)
    {
        $company = Auth::user()->company;
        $company->update($request->validated());

        return new CompanyResource($company);
    }

    public function destroy(Company $company)
    {
        $company = Auth::user()->company;
        $company->delete();

        return response()->noContent();
    }
}
