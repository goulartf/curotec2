<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function it_creates_resources()
    {
        $contact = Contact::factory()->raw();

        $response = $this->post('/contacts', [$contact]);

        $response->assertSuccessful()->assertJson([
            'name' => $contact['name'],
            'email' => $contact['email'],
            'phone' => $contact['phone'],
        ]);
    }

    public function it_updates_resources()
    {
        $contact = Contact::factory()->create();
        $newData = Contact::factory()->raw();

        $response = $this->patch('/contacts/'.$contact->id, [$contact]);

        $response->assertSuccessful()->assertJson([
            'name' => $newData['name'],
            'email' => $newData['email'],
            'phone' => $newData['phone'],
        ]);
    }

    public function it_deletes_resources(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->delete('/contacts/'.$contact->id);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact
        ]);
    }
}
