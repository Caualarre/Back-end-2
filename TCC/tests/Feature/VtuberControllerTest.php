<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Vtuber;
use App\Models\Usuario;
use App\Models\Empresa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VtuberControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_vtubers_with_media_nota()
    {
        $usuario = Usuario::factory()->create();
        $empresa = Empresa::factory()->create();
        $vtuber = Vtuber::factory()->create(['empresa_id' => $empresa->id]);
        $vtuber->usuarios()->attach($usuario, ['nota' => 5]);

        $response = $this->getJson(route('vtubers.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([ '*' => ['id', 'nome', 'media_nota'] ]);
    }

    public function test_filtro_applies_filters_correctly()
    {
        $empresa1 = Empresa::factory()->create();
        $empresa2 = Empresa::factory()->create();
    
        $vtuber1 = Vtuber::factory()->create(['nome' => 'VTuber 1', 'empresa_id' => $empresa1->id]);
        $vtuber2 = Vtuber::factory()->create(['nome' => 'VTuber 2', 'empresa_id' => $empresa2->id]);
    
        // Testando o filtro por nome
        $response = $this->getJson('/api/vtubers-filtro?nome=VTuber 1');
        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['nome' => 'VTuber 1']);
    
        // Testando o filtro por empresa_id
        $response = $this->getJson('/api/vtubers-filtro?empresa_id=' . $empresa2->id);
        $response->assertStatus(200);
        $response->assertJsonFragment(['empresa_id' => $empresa2->id]);
    }

    public function test_store_creates_vtuber()
    {
        $usuario = Usuario::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'imagem' => 'admin_avatar.png',
        ]);
    
        $responseLogin = $this->postJson('/api/login', [
            'email' => $usuario->email,
            'password' => 'password123',
        ]);

        $token = $responseLogin->json('token');
    
        $empresa = Empresa::factory()->create();
        $imagem = UploadedFile::fake()->create('vtuber_avatar.png', 100); 

        $data = [
            'nome' => 'VTuber Test',
            'descricao' => 'Test description',
            'empresa_id' => $empresa->id,
            'imagem' => $imagem,
        ];

        $response = $this->postJson(route('vtubers.store'), $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['message' => 'Vtuber Criado!']);
        $this->assertDatabaseHas('vtubers', ['nome' => 'VTuber Test']);
    }

    public function test_show_returns_vtuber_details()
    {
        $usuario = Usuario::factory()->create();
        $empresa = Empresa::factory()->create();
        $vtuber = Vtuber::factory()->create(['empresa_id' => $empresa->id]);

        $vtuber->usuarios()->attach($usuario, ['nota' => 5]);

        $response = $this->getJson(route('vtubers.show', $vtuber->id));

        $response->assertStatus(200);
        $response->assertJsonFragment(['nome' => $vtuber->nome]);

        $mediaNotaFormatada = number_format(5, 2, '.', '');
        $response->assertJsonFragment(['media_nota' => $mediaNotaFormatada]);
    }

    public function test_update_updates_vtuber()
    {
        $usuario = Usuario::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'imagem' => 'admin_avatar.png',
        ]);
    
        $responseLogin = $this->postJson('/api/login', [
            'email' => $usuario->email,
            'password' => 'password123',
        ]);

        $token = $responseLogin->json('token');
    
        $empresa = Empresa::factory()->create();
        $vtuber = Vtuber::factory()->create(['empresa_id' => $empresa->id]);

        $data = [
            'nome' => 'Updated VTuber',
            'descricao' => 'Updated description',
        ];

        $response = $this->putJson(route('vtubers.update', $vtuber->id), $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Vtuber atualizada com sucesso']);
        $response->assertJsonFragment(['nome' => 'Updated VTuber']);
    }

    public function test_destroy_deletes_vtuber()
    {
        $usuario = Usuario::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'imagem' => 'admin_avatar.png',
        ]);
    
        $responseLogin = $this->postJson('/api/login', [
            'email' => $usuario->email,
            'password' => 'password123',
        ]);

        $token = $responseLogin->json('token');
    
        $empresa = Empresa::factory()->create();
        $vtuber = Vtuber::factory()->create(['empresa_id' => $empresa->id]);

        $response = $this->deleteJson(route('vtubers.destroy', $vtuber->id), [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Vtuber deletada com sucesso']);
        $this->assertDatabaseMissing('vtubers', ['id' => $vtuber->id]);
    }

    // **Testes de Exclusão de VTuber Inexistente ou Já Excluída**

    public function test_destroy_returns_error_for_non_existent_vtuber()
    {
        $usuario = Usuario::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'imagem' => 'admin_avatar.png',
        ]);
    
        $responseLogin = $this->postJson('/api/login', [
            'email' => $usuario->email,
            'password' => 'password123',
        ]);
    
        $token = $responseLogin->json('token');
    
        $invalidVtuberId = 99999;  // Um ID de VTuber que não existe.
    
        // Tenta deletar um VTuber inexistente
        $response = $this->deleteJson(route('vtubers.destroy', $invalidVtuberId), [], [
            'Authorization' => 'Bearer ' . $token,
        ]);
    
        $response->assertStatus(404);
    }

    // **Testes de Análise de Valor Limite**

    public function test_create_vtuber_with_max_name_length()
    {
        $usuario = Usuario::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'imagem' => 'admin_avatar.png',
        ]);

        $responseLogin = $this->postJson('/api/login', [
            'email' => $usuario->email,
            'password' => 'password123',
        ]);

        $token = $responseLogin->json('token');
    
        $empresa = Empresa::factory()->create();
        $imagem = UploadedFile::fake()->create('vtuber_avatar.png', 100);

        $data = [
            'nome' => str_repeat('A', 255),  // Nome com o limite de 255 caracteres
            'descricao' => 'Test description',
            'empresa_id' => $empresa->id,
            'imagem' => $imagem,
        ];

        $response = $this->postJson(route('vtubers.store'), $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(201);
    }

    public function test_create_vtuber_with_empty_name()
    {
        $usuario = Usuario::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'imagem' => 'admin_avatar.png',
        ]);

        $responseLogin = $this->postJson('/api/login', [
            'email' => $usuario->email,
            'password' => 'password123',
        ]);

        $token = $responseLogin->json('token');
    
        $empresa = Empresa::factory()->create();
        $imagem = UploadedFile::fake()->create('vtuber_avatar.png', 100);

        $data = [
            'nome' => '',  // Nome vazio, deve ser inválido
            'descricao' => 'Test description',
            'empresa_id' => $empresa->id,
            'imagem' => $imagem,
        ];

        $response = $this->postJson(route('vtubers.store'), $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(422);  // Espera um erro de validação
    }

    // **Testes de Particionamento de Equivalência**

    public function test_create_vtuber_with_invalid_image_format()
    {
        $usuario = Usuario::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'imagem' => 'admin_avatar.png',
        ]);
    
        $responseLogin = $this->postJson('/api/login', [
            'email' => $usuario->email,
            'password' => 'password123',
        ]);

        $token = $responseLogin->json('token');
    
        $empresa = Empresa::factory()->create();
        $imagem = UploadedFile::fake()->create('invalid_file.txt', 100);  // Arquivo inválido

        $data = [
            'nome' => 'VTuber Test',
            'descricao' => 'Test description',
            'empresa_id' => $empresa->id,
            'imagem' => $imagem,
        ];

        $response = $this->postJson(route('vtubers.store'), $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(422);  // Espera um erro de validação
    }
}

