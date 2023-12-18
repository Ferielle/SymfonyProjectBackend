<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Loader;
use App\DataFixtures\EvenementFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger; 

class EvenementControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        
        if (null === static::$kernel) {
            static::bootKernel();
        }
        $entityManager = static::$container->get('doctrine')->getManager();

        // Load fixtures before each test
        $loader = new Loader();
        $loader->addFixture(new EvenementFixtures());
        $executor = new ORMExecutor($entityManager, new ORMPurger());
        $executor->execute($loader->getFixtures());
    }

    public function testGetEvenements()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        // Replace '/api/Evenements' with your actual GET API endpoint
        $client->request('GET', '/api/evenement/');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());

        $responseData = json_decode($client->getResponse()->getContent(), true);

        // Assuming your API returns the created Evenement data
        foreach ($responseData as $event) {
            $this->assertArrayHasKey('@id', $event);
            $this->assertArrayHasKey('titre', $event);
            $this->assertArrayHasKey('description', $event);
            $this->assertArrayHasKey('date_de_debut', $event);
            $this->assertArrayHasKey('date_de_fin', $event);
            $this->assertArrayHasKey('lieu', $event);
        }
    }

    public function testPostEvenement()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        // Replace '/api/Evenements' with your actual POST API endpoint
        $client->request(
            'POST',
            '/api/evenement/new', // Corrected the endpoint
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "titre": "l \'événement modified",
                "description": "Description de l événement",
                "date_de_debut": "2023-12-31T00:00:00+01:00",
                "date_de_fin": "2024-01-02T00:00:00+01:00",
                "lieu": "Lieu de l\'événement"
            }'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Evenement added successfully', $responseData['message']);
    }

    public function testPutEvenement()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        // Replace '/api/Evenements/{id}' with your actual PUT API endpoint
        $EvenementIdToUpdate = 1; // Replace with the ID of an existing Evenement
        $client->request(
            'PUT',
            '/api/evenement/' . $EvenementIdToUpdate . '/edit', // Corrected the endpoint
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "titre": "l \'événement modifiée",
                "description": "Description de l événement",
                "date_de_debut": "2023-12-31T00:00:00+01:00",
                "date_de_fin": "2024-01-02T00:00:00+01:00",
                "lieu": "Lieu de l\'événement 123"
            }'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Evenement updated successfully', $responseData['message']);
    }

    public function testDeleteEvenement()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $EvenementIdToDelete = 5; // Replace with the ID of an existing Evenement
        $client->request('DELETE', '/api/evenement/' . $EvenementIdToDelete); // Corrected the endpoint

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Evenement deleted successfully', $responseData['message']);

        // Additional assertions based on your API response or database state
    }
}
