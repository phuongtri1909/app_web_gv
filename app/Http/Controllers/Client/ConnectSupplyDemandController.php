public function storeConnectSupplyDemand(Request $request)
{
    $validated = $request->validate([
        'owner_full_name' => 'required|string|max:255',
        'birth_year' => 'required|integer|min:1800|max:' . date('Y'),
        'gender' => 'required|in:male,female,other',
        'residential_address' => 'required|string|max:255',
        'business_address' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'business_code' => 'required|string|max:50',
        'business_name' => 'required|string|max:255',
        'business_field' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'fanpage' => 'nullable|url|max:255',
        'product_info' => 'required|string',
        'product_standard' => 'required|string',
        'product_avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'product_price' => 'required|numeric|min:0',
        'product_price_mini_app' => 'required|numeric|min:0',
        'product_price_member' => 'required|numeric|min:0',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
    ]);

    // Handle product avatar upload
    $avatarPath = $request->file('product_avatar')->store('product-avatars', 'public');

    // Handle multiple product images
    $productImagePaths = [];
    if ($request->hasFile('product_images')) {
        foreach ($request->file('product_images') as $image) {
            $productImagePaths[] = $image->store('product-images', 'public');
        }
    }

    $connection = SupplyDemandConnection::create([
        'owner_full_name' => $validated['owner_full_name'],
        'birth_year' => $validated['birth_year'],
        'gender' => $validated['gender'],
        'residential_address' => $validated['residential_address'],
        'business_address' => $validated['business_address'],
        'phone' => $validated['phone'],
        'business_code' => $validated['business_code'],
        'business_name' => $validated['business_name'],
        'business_field' => $validated['business_field'],
        'email' => $validated['email'],
        'fanpage' => $validated['fanpage'],
        'product_info' => $validated['product_info'],
        'product_standard' => $validated['product_standard'],
        'product_avatar' => $avatarPath,
        'product_images' => json_encode($productImagePaths),
        'product_price' => $validated['product_price'],
        'product_price_mini_app' => $validated['product_price_mini_app'],
        'product_price_member' => $validated['product_price_member'],
        'start_date' => $validated['start_date'],
        'end_date' => $validated['end_date'],
    ]);

    return redirect()->back()->with('success', 'Đăng ký kết nối cung cầu thành công!');
}
