<?php

class OAuthSeeder extends Seeder
{
    function run()
    {
        DB::table('oauth_client_grants')->delete();
        DB::table('oauth_client_scopes')->delete();
        DB::table('oauth_client_endpoints')->delete();
        DB::table('oauth_clients')->delete();
        DB::table('oauth_scopes')->delete();
        DB::table('oauth_grants')->delete();
        $this->seedScopes();
        $this->seedGrants();
        $this->seedClients();

    }

    private function seedScopes()
    {
        $scopes = array(
            array(
                'scope' => 'basic',
                'name' => 'Basic Scope',
                'description' => 'Covers basic functions',
            ),
        );
        foreach ($scopes as $scope)
        {
            DB::table('oauth_scopes')->insert(array_merge($scope,$this->timestamps()));
        }

    }
    
    private function seedGrants()
    {
        $grants = array(
            array(
                'grant' => 'password',
            ),
            array(
                'grant' => 'client_credentials',
            ),
            array(
                'grant' => 'authorization_code',
            ),
            array(
                'grant' => 'refresh_token'
            )
        );
        foreach ($grants as $grant)
        {
            DB::table('oauth_grants')->insert(array_merge($grant,$this->timestamps()));
        }

        $grant = DB::table('oauth_grants')->where('grant','client_credentials')->first();
        $scope = DB::table('oauth_scopes')->where('scope','basic')->first();
        DB::table('oauth_grant_scopes')->insert(array_merge(array('grant_id' => $grant->id,'scope_id' => $scope->id),$this->timestamps()));

        $grant = DB::table('oauth_grants')->where('grant','password')->first();
        $scope = DB::table('oauth_scopes')->where('scope','basic')->first();
        DB::table('oauth_grant_scopes')->insert(array_merge(array('grant_id' => $grant->id,'scope_id' => $scope->id),$this->timestamps()));

        $grant = DB::table('oauth_grants')->where('grant','authorization_code')->first();
        $scope = DB::table('oauth_scopes')->where('scope','basic')->first();
        DB::table('oauth_grant_scopes')->insert(array_merge(array('grant_id' => $grant->id,'scope_id' => $scope->id),$this->timestamps()));

    }

    private function seedClients()
    {


        $clients = array(
            array(
            'name' => 'Todo Sample Client',
            'id' => 'special-key',
            'secret' => 'special-secret',
            'endpoints' => [
                '*',
            ],
            'scopes' => ['basic'],
            'grants' => ['password','authorization_code' ,'client_credentials','refresh_token']
        ));

        foreach ($clients as $client)
        {
            DB::table('oauth_clients')->insert(array_merge(array(
                'name' => $client['name'],
                'id' => $client['id'],
                'secret' => $client['secret'],
            ),$this->timestamps()));

            foreach ($client['endpoints'] as $uri)
            {
                DB::table('oauth_client_endpoints')->insert(array_merge(array(
                    'client_id' => $client['id'],
                    'redirect_uri' => $uri,
                ),$this->timestamps()));
            }

            $scope_ids = DB::table('oauth_scopes')->whereIN('scope',$client['scopes'])->lists('id');
            foreach ($scope_ids as $scope)
            {
                DB::table('oauth_client_scopes')->insert(array_merge(array(
                    'client_id' => $client['id'],
                    'scope_id' => $scope,
                ),$this->timestamps()));
            }

            $grant_ids = DB::table('oauth_grants')->whereIN('grant',$client['grants'])->lists('id');
            foreach ($grant_ids as $grant)
            {
                DB::table('oauth_client_grants')->insert(array_merge(array(
                    'client_id' => $client['id'],
                    'grant_id' => $grant,
                ),$this->timestamps()));
            }

        }

    }

    private function timestamps()
    {
        return array(
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
    }


} 