<?php

// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Instrument;
use App\Models\InstrumentImage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Usuários ──────────────────────────────────────────────────
        $this->call([ProductSeeder::class]); // mantém o seeder do professor

        $admin = User::factory()->create([
            'name'     => 'Admin thRIFFt',
            'email'    => 'admin@thrifft.com',
            'password' => Hash::make('password'),
            'bio'      => 'Administrador do marketplace. Apaixonado por guitarras vintage.',
        ]);

        $riff = User::factory()->create([
            'name'     => 'Riff Seller',
            'email'    => 'seller@thrifft.com',
            'password' => Hash::make('password'),
            'bio'      => 'Músico profissional desapegando de peças da coleção.',
        ]);

        $groove = User::factory()->create([
            'name'     => 'Groove Bass',
            'email'    => 'groove@thrifft.com',
            'password' => Hash::make('password'),
            'bio'      => 'Baixista há 20 anos. Gear de qualidade pelo justo.',
        ]);

        // ── Categorias ────────────────────────────────────────────────
        $categories = [
            ['name' => 'Cordas',         'type' => 'corda',        'color' => '#B45309'],
            ['name' => 'Teclas',         'type' => 'tecla',        'color' => '#1D4ED8'],
            ['name' => 'Percussão',      'type' => 'percussão',    'color' => '#6D28D9'],
            ['name' => 'Amplificadores', 'type' => 'amplificador', 'color' => '#DC2626'],
        ];

        foreach ($categories as $data) {
            Category::create($data);
        }

        $catCordas  = Category::where('name', 'Cordas')->first();
        $catTeclas  = Category::where('name', 'Teclas')->first();
        $catPerc    = Category::where('name', 'Percussão')->first();
        $catAmp     = Category::where('name', 'Amplificadores')->first();

        // ── Instrumentos ──────────────────────────────────────────────
        // Placeholder de imagem pública (400×300) para desenvolvimento.
        // Substitua pelos uploads reais após rodar php artisan storage:link.
        $placeholder = 'https://placehold.co/400x300/451A03/FBBF24?text=thRIFFt';

        $instruments = [
            [
                'user'       => $admin,
                'data'       => [
                    'title'       => 'Fender Stratocaster American Professional II',
                    'description' => 'Stratocaster série 2021 em Olympic White, captadores V-Mod II, muito bem conservada. Acompanha case original.',
                    'price'       => 8900.00,
                    'brand'       => 'Fender',
                    'condition'   => 'Mint Riff',
                    'status'      => 'active',
                ],
                'categories' => [$catCordas->id],
            ],
            [
                'user'       => $admin,
                'data'       => [
                    'title'       => 'Gibson Les Paul Standard 60s',
                    'description' => 'Les Paul clássica no tom Bourbon Burst. Tocada em shows, alguns roces mínimos no corpo — não afetam a eletrônica. Captadores Burstbucker Pro originais.',
                    'price'       => 12500.00,
                    'brand'       => 'Gibson',
                    'condition'   => 'Good Riff',
                    'status'      => 'active',
                ],
                'categories' => [$catCordas->id],
            ],
            [
                'user'       => $riff,
                'data'       => [
                    'title'       => 'Marshall JCM800 2203 100W Head',
                    'description' => 'Amplificador valvulado clássico, série dos 80s. Revisado há 6 meses com válvulas novas (JJ Electronics). Sonzão de estúdio.',
                    'price'       => 9800.00,
                    'brand'       => 'Marshall',
                    'condition'   => 'Good Riff',
                    'status'      => 'active',
                ],
                'categories' => [$catAmp->id],
            ],
            [
                'user'       => $riff,
                'data'       => [
                    'title'       => 'Roland Juno-106 Sintetizador Vintage',
                    'description' => 'Sintetizador polifônico icônico dos anos 80. Todos os 106 VCFs trocados por chips novos (reparo completo). Sons inconfundíveis de synthpop e new wave.',
                    'price'       => 6200.00,
                    'brand'       => 'Roland',
                    'condition'   => 'Mint Riff',
                    'status'      => 'active',
                ],
                'categories' => [$catTeclas->id],
            ],
            [
                'user'       => $groove,
                'data'       => [
                    'title'       => 'Fender Jazz Bass American Original 60s',
                    'description' => 'Jazz Bass em 3-Color Sunburst, captadores de bobina dupla vintagey. Plugue do input levemente amassado por queda, sem impacto no sinal. Acompanha bag.',
                    'price'       => 7400.00,
                    'brand'       => 'Fender',
                    'condition'   => 'Heavy Riff',
                    'status'      => 'active',
                ],
                'categories' => [$catCordas->id],
            ],
            [
                'user'       => $groove,
                'data'       => [
                    'title'       => 'Pearl Export EXX 5pc Bateria Completa',
                    'description' => 'Kit completo 22" bombo, 10"/12"/16" toms + 14" caixa. Pratos Zildjian ZBT inclusos. Ferragens Pearl 830 Series. Perfeita para ensaio.',
                    'price'       => 3500.00,
                    'brand'       => 'Pearl',
                    'condition'   => 'Good Riff',
                    'status'      => 'active',
                ],
                'categories' => [$catPerc->id],
            ],
            [
                'user'       => $admin,
                'data'       => [
                    'title'       => 'Fender Rhodes Mark I Stage 73',
                    'description' => 'Piano elétrico lendário dos anos 70. Tanques afinados, ação das teclas ajustada. Levíssimo barulho mecânico nos agudos, característico da idade.',
                    'price'       => 5800.00,
                    'brand'       => 'Fender',
                    'condition'   => 'Heavy Riff',
                    'status'      => 'active',
                ],
                'categories' => [$catTeclas->id],
            ],
            [
                'user'       => $riff,
                'data'       => [
                    'title'       => 'Orange Rocker 32 Combo 2x10"',
                    'description' => 'Combo valvulado de 30W em modo stereo (15W por lado). Tom clássico laranja. Praticamente sem uso — comprado, rodei 3 shows e migrei para um cabeçote.',
                    'price'       => 5100.00,
                    'brand'       => 'Orange',
                    'condition'   => 'Mint Riff',
                    'status'      => 'active',
                ],
                'categories' => [$catAmp->id],
            ],
            [
                'user'       => $groove,
                'data'       => [
                    'title'       => 'Gretsch Renown Maple 4pc — Tobacco Burst',
                    'description' => 'Kit de estúdio com 22" bombo, 12"/16" toms e 14" caixa. Peles Remo novas. Corpo e ferragens em ótimo estado.',
                    'price'       => 4200.00,
                    'brand'       => 'Gretsch',
                    'condition'   => 'Good Riff',
                    'status'      => 'active',
                ],
                'categories' => [$catPerc->id],
            ],
            [
                'user'       => $admin,
                'data'       => [
                    'title'       => 'PRS SE Custom 24 — Trampas Green',
                    'description' => 'Guitarra PRS SE belíssima. Captadores PRS 85/15 "S", vibrato PRS SE. Nunca saiu do apartamento. Acompanha bag PRS.',
                    'price'       => 3200.00,
                    'brand'       => 'PRS',
                    'condition'   => 'Mint Riff',
                    'status'      => 'active',
                ],
                'categories' => [$catCordas->id],
            ],
            [
                'user'       => $riff,
                'data'       => [
                    'title'       => 'Roland TD-17KVX Bateria Eletrônica',
                    'description' => 'Kit eletrônico com módulo TD-17, pratos e bumbo de mesh. Ideal para quem mora em apartamento. Acompanha rack e cabos.',
                    'price'       => 5600.00,
                    'brand'       => 'Roland',
                    'condition'   => 'Good Riff',
                    'status'      => 'active',
                ],
                'categories' => [$catPerc->id],
            ],
            [
                'user'       => $groove,
                'data'       => [
                    'title'       => 'Ampeg SVT-CL 300W Bass Amplifier Head',
                    'description' => 'O rei dos amplificadores de baixo. Válvulas trocadas há 2 anos. Diversas sujeiras de estúdio no chassis, mas o sinal é intocável.',
                    'price'       => 8200.00,
                    'brand'       => 'Ampeg',
                    'condition'   => 'Heavy Riff',
                    'status'      => 'active',
                ],
                'categories' => [$catAmp->id],
            ],
        ];

        foreach ($instruments as $entry) {
            $instrument = $entry['user']->instruments()->create($entry['data']);
            $instrument->categories()->attach($entry['categories']);

            // Cada instrumento começa com uma imagem de capa (placeholder).
            // Em produção, substitua pela URL do Storage após upload real.
            InstrumentImage::create([
                'instrument_id' => $instrument->id,
                'image_path'    => $placeholder,
                'is_cover'      => true,
            ]);
        }
    }
}
