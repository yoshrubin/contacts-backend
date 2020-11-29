<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Contact;
use Illuminate\Foundation\Testing\WithFaker;

class ContactTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    public function testCreateContact()
    {
        $contact = [
            'name' => $this->faker->name,
            'phone' => $this->faker->e164PhoneNumber,
            'title' => $this->faker->title,
            'avatar' => 'path/to/image.jpg'
        ];

        $response = $this->post(
            '/api/contacts',
            $contact
        );

        $response->assertStatus(201);

        $data = $response->json();

        $this->assertEquals($contact['name'], $data['name']);
        $this->assertEquals($contact['phone'], $data['phone']);
        $this->assertEquals($contact['title'], $data['title']);
        $this->assertEquals($contact['avatar'], $data['avatar']);
    }

    public function testShowContact()
    {
        $contact = Contact::factory()->create();

        $id = $contact->id;

        $response = $this->get('/api/contacts/'.$id);

        $response->assertStatus(200);
    }

    public function testListContact()
    {
        Contact::factory(10)->create();

        $response = $this->get('/api/contacts');

        $response->assertStatus(200);

        $data = $response->json();

        $this->assertEquals(10, $data['total']);
    }

    public function testUpdateContact()
    {
        $contact = Contact::factory()->create();

        $id = $contact->id;

        $updatedContact = [
            'name' => 'testName',
            'phone' => 'numbertest',
            'title' => 'titleTest',
            'avatar' => 'path/to/imageTest.jpg'
        ];

        $response = $this->put(
            '/api/contacts/'.$id,
            $updatedContact
        );

        $response->assertStatus(200);

        $data = $response->json();

        $this->assertEquals($updatedContact['name'], $data['name']);
        $this->assertEquals($updatedContact['phone'], $data['phone']);
        $this->assertEquals($updatedContact['title'], $data['title']);
        $this->assertEquals($updatedContact['avatar'], $data['avatar']);

    }

    public function testDeleteContact()
    {
        $contact = Contact::factory()->create();

        $id = $contact->id;

        $response = $this->delete('api/contacts/'.$id);

        $response->assertStatus(200);

        $deleted = Contact::find($id);

        $this->assertEquals($deleted, null);
    }
}
