<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    // === WEB (Customer - publik, tanpa login) ===
    public function indexWeb()
    {
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    // === WEB (Owner - butuh login) ===
    public function ownerIndex()
    {
        $menus = Menu::all();
        return view('owner.menu.index', compact('menus'));
    }

    public function search(Request $request)
    {
        $menus = Menu::where('name', 'like', "%{$request->q}%")->get();
        return view('menu.index', compact('menus'));
    }

    public function create()
    {
        return view('menu.create');
    }

    public function storeWeb(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $this->handleImage($request, null);
        Menu::create($data);
        
        return redirect()->route('owner.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        return view('menu.edit', compact('menu'));
    }

    public function updateWeb(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $this->handleImage($request, $menu);
        $menu->update($data);
        
        return redirect()->route('owner.menu.index')->with('success', 'Menu berhasil diupdate!');
    }

    public function destroyWeb(Menu $menu)
    {
        $this->deleteImage($menu);
        $menu->delete();
        return redirect()->route('owner.menu.index')->with('success', 'Menu berhasil dihapus!');
    }

    // === REST API ===
    public function index()
    {
        return response()->json(Menu::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        return response()->json(Menu::create($request->only('name', 'description', 'price')), 201);
    }

    public function show(Menu $menu)
    {
        return response()->json($menu);
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        $menu->update($request->only('name', 'description', 'price'));
        return response()->json($menu);
    }

    public function destroy(Menu $menu)
    {
        $this->deleteImage($menu);
        $menu->delete();
        return response()->json(null, 204);
    }

    // === Helper Methods ===
    private function handleImage(Request $request, ?Menu $menu = null)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu && $menu->image && file_exists(public_path($menu->image))) {
                unlink(public_path($menu->image));
            }

            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName);
            $data['image'] = 'images/' . $fileName;
        }

        return $data;
    }

    private function deleteImage(Menu $menu)
    {
        if ($menu->image && file_exists(public_path($menu->image))) {
            unlink(public_path($menu->image));
        }
    }
}