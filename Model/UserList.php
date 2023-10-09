<?php

class UserList
{
    const FIELDS = [
        'full_name' => 'Fullname',
        'phone' => 'Phone Number',
        'email' => 'Email',
        'country' => 'Country Name'
    ];

    public function prepareData($data): array
    {
        $result = [];
        $convertedData = json_decode($data);

        foreach ($convertedData->results as $entity) {
            $entityData = [];
            $entityData['full_name'] = $entity->name->first . ' ' . $entity->name->last;
            $entityData['phone'] = $entity->phone;
            $entityData['email'] = $entity->email;
            $entityData['country'] = $entity->location->country;

            $result[] = $entityData;
        }

        if (!empty($_GET['order_by']) && !empty($_GET['order'])) {
            $result = $this->sortDataByUrlParams($result, $_GET['order_by'], $_GET['order']);
        }

        return $result;
    }

    private function sortDataByUrlParams(array $data, $orderColumn, $orderDirection ): array
    {
        $direction = SORT_ASC;
        if ('desc' === $orderDirection) {
            $direction = SORT_DESC;
        }
        //or go thought all items, set key sorting column, and then apply direction (array_reverse)
        array_multisort( array_column( $data, $orderColumn ), $direction, SORT_STRING, $data );

        return $data;
    }
}