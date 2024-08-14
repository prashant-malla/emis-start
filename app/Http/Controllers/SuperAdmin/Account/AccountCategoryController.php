<?php

namespace App\Http\Controllers\SuperAdmin\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountCategoryRequest;
use App\Models\AccountCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccountCategoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $data['primaryCategories'] = AccountCategory::whereNull('parent_id')->get();

        if ($request->parent_id) {
            $data['categories'] = AccountCategory::where('parent_id', $request->parent_id)->get();
        } else {
            $data['categories'] = $data['primaryCategories'];
        }

        return view('pages.account.category.index', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = AccountCategory::whereNull('parent_id')->get();

        return view('pages.account.category.form', compact('categories'));
    }

    /**
     * @param AccountCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store(AccountCategoryRequest $request)
    {
        $request['slug'] = Str::slug($request->name);

        AccountCategory::create($request->all());

        return redirect()->route('account_category.index')->with('success', 'Created successfully');
    }

    /**
     * @param $accountCategory
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(AccountCategory $accountCategory)
    {
        $categories = AccountCategory::whereNull('parent_id')->where('id', '!=', $accountCategory->id)->get();

        return view('pages.account.category.form', compact('accountCategory', 'categories'));
    }

    /**
     * @param AccountCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function update(AccountCategoryRequest $request, AccountCategory $accountCategory)
    {
        $request['slug'] = Str::slug($request->name);
        $accountCategory->update($request->all());
        return redirect()->route('account_category.index')->with('success', 'Updated successfully');
    }


    public function destroy(AccountCategory $accountCategory)
    {
        $accountCategory->loadCount('children');
        if ($accountCategory->children_count > 0) {
            return redirect()->route('account_category.index')->with('error', 'Please delete child categories first');
        }

        $accountCategory->loadCount('ledgerAccounts');
        if ($accountCategory->ledger_accounts_count > 0) {
            return redirect()->route('account_category.index')->with('error', 'Please delete associated ledger accounts first');
        }

        $accountCategory->delete();
        return redirect()->route('account_category.index')->with('success', 'Deleted successfully');
    }
}
