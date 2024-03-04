<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\BannerImage;

class BannerImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerDatas = [
            ["description" => '<h1 class="paragraph"> 1 Star Global Entertainment Inc presents the</h1>
                                <h1 class="hero-heading mb-md-3">Real Ladies Reloaded Concert!</h1>
                                <p class="hero_paragraph">Trina The Diamond Princess Also Performing Live Kitty Millian and Barbie Bank Rose</p>',
            "banner_image" => "banner1.png",
            "status" => 1],
            ["description" => '<h1 class="paragraph"> 2 Star Global Entertainment Inc presents the</h1>
                                <h1 class="hero-heading mb-md-3">Real Ladies Reloaded Concert!</h1>
                                <p class="hero_paragraph">Trina The Diamond Princess Also Performing Live Kitty Millian and Barbie Bank Rose</p>',
            "banner_image" => "banner2.png",
            "status" => 1],
            ["description" => '<h1 class="paragraph"> 3 Star Global Entertainment Inc presents the</h1>
                                <h1 class="hero-heading mb-md-3">Real Ladies Reloaded Concert!</h1>
                                <p class="hero_paragraph">Trina The Diamond Princess Also Performing Live Kitty Millian and Barbie Bank Rose</p>',
            "banner_image" => "banner3.png",
            "status" => 1],
            ["description" => '<h1 class="paragraph"> 4 Star Global Entertainment Inc presents the</h1>
                                <h1 class="hero-heading mb-md-3">Real Ladies Reloaded Concert!</h1>
                                <p class="hero_paragraph">Trina The Diamond Princess Also Performing Live Kitty Millian and Barbie Bank Rose</p>',
            "banner_image" => "banner4.png",
            "status" => 1]
        ];
        foreach ($bannerDatas as $bannerData) {
            BannerImage::create([
                'description'   => $bannerData['description'],
                'banner_image'  => $bannerData['banner_image'],
                'status'        => $bannerData['status'],
            ]);
        }
    }
}
