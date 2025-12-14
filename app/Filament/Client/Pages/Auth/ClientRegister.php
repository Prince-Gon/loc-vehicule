<?php

namespace App\Filament\Client\Pages\Auth;

use Filament\Pages\Page;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\User;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ClientRegister extends BaseRegister
{
  // protected string $view = 'filament.client.pages.auth.client-register';

  public function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        // $this->getNameFormComponent()
        //   ->label('Nom complet')
        //   ->required(),

        $this->getEmailFormComponent()
          ->unique(User::class, 'email'),

        TextInput::make('first_name')
          ->label('First Name')
          ->required()
          ->maxLength(100),

        TextInput::make('last_name')
          ->label('Last Name')
          ->required()
          ->maxLength(100),

        TextInput::make('phone')
          ->label('Phone Number')
          ->tel()
          ->required()
          ->maxLength(10)
          ->placeholder('0xxxxxxxxx'),
        TextInput::make('driver_license_number')
          ->label('Driving License Number')
          ->required()
          ->maxLength(50)
          ->unique(Client::class, 'driver_license_number'),
        TextInput::make('address')
          ->label('Address')
          ->required()
          ->columnSpanFull()
          ->placeholder('123 Road Example, 75000 Algeria'),

        $this->getPasswordFormComponent(),

        $this->getPasswordConfirmationFormComponent(),
      ])
      ->statePath('data');
  }


  // protected function handleRegistration(array $data): User
  // {
  //   // Transaction pour créer User ET Client en même temps
  //   return DB::transaction(function () use ($data) {
  //     // 1. Créer l'utilisateur
  //     $user = User::create([
  //       'name' => $data['name'],
  //       'email' => $data['email'],
  //       'password' => Hash::make($data['password']),
  //     ]);

  //     // 2. Assigner le rôle "client"
  //     $user->assignRole('client');

  //     // 3. Créer le profil client lié à l'utilisateur
  //     Client::create([
  //       'user_id' => $user->id,
  //       'first_name' => $data['first_name'],
  //       'last_name' => $data['last_name'],
  //       'email' => $data['email'],
  //       'phone' => $data['phone'],
  //       'driving_license_number' => $data['driving_license_number'],
  //       'address' => $data['address'],
  //     ]);

  //     return $user;
  //   });
  // }
}
