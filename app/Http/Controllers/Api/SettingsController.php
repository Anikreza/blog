<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class SettingsController extends ApiController
{
    public function get(): array
    {
        return $this->getSettings();
    }

    public function set(Request $request): JsonResponse
    {
        $settings = $this->getSettings();
        if (!$settings) {
            $settings = [];
        }

        if ($request->hasFile('home_page_image') && $request->home_page_image) {
            $extension = $request->file('home_page_image')->getClientOriginalExtension();
            $settings['home_page_image_url'] = 'home_page_image_' . time() . '.' . $extension;
            Storage::disk('public')->putFileAs('settings', $request->file('home_page_image'), $settings['home_page_image_url']);
        }

        $settings = $request->except('home_page_image');
        $settings = array_merge($settings, $request->all());

        setting([
            'general' => json_encode($settings)
        ])->save();

        return $this->successResponse();
    }

    private function getSettings(): array
    {
        $settings = setting()->get('general');
        if ($settings) {
            $settings = json_decode($settings, true);
        } else
            return [];

        if (Arr::get($settings, 'home_page_image_url')) {
            $settings['home_page_image_url'] = Storage::disk('public')->url('settings/' . basename($settings['home_page_image_url']));
        }

        return $settings;
    }
}
