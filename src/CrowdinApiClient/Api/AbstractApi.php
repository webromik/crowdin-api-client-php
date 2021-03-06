<?php

namespace CrowdinApiClient\Api;

use CrowdinApiClient\Crowdin;
use CrowdinApiClient\Http\ResponseDecorator\ResponseModelDecorator;
use CrowdinApiClient\Http\ResponseDecorator\ResponseModelListDecorator;
use CrowdinApiClient\Model\ModelInterface;

/**
 * Class AbstractApi
 * @package Crowdin\Api
 */
abstract class AbstractApi implements ApiInterface
{
    /**
     * @var Crowdin
     */
    protected $client;

    /**
     * @param Crowdin $client
     */
    public function __construct(Crowdin $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $path
     * @param ModelInterface $model
     * @return mixed
     */
    protected function _update(string $path, ModelInterface $model)
    {
        $dataModel = $model->getProperties();

        $_data = [];

        foreach ($model->getData() as $key => $val) {
            if (isset($dataModel[$key]) && $dataModel[$key] != $val) {
                $_data[] = [
                    'op' => 'replace',
                    'path' => '/' . $key,
                    'value' => $dataModel[$key]
                ];
            }
        }

        if (empty($_data)) {
            return $model;
        }

        $options = [
            'body' => json_encode($_data),
            'headers' => ['Content-Type' => 'application/json']
        ];

        return $this->client->apiRequest('patch', $path, new ResponseModelDecorator(get_class($model)), $options);
    }

    /**
     * @param string $path
     * @param string $modelName
     * @param array $params
     * @return mixed
     */
    protected function _list(string $path, string $modelName, array $params = [])
    {
        $options = [];

        if (!empty($params)) {
            $options['params'] = $params;
        }

        return $this->client->apiRequest('get', $path, new ResponseModelListDecorator($modelName), $options);
    }

    /**
     * @param string $path
     * @param string $modelName
     * @param array $data
     * @return mixed
     */
    protected function _create(string $path, string $modelName, array $data)
    {
        $options = [
            'body' => json_encode($data),
            'headers' => ['Content-Type' => 'application/json']
        ];

        return $this->client->apiRequest('post', $path, new ResponseModelDecorator($modelName), $options);
    }

    /**
     * @param string $path
     * @param array $params
     * @return mixed
     */
    protected function _delete(string $path, array $params = [])
    {
        return $this->client->apiRequest('delete', $path, null, $params);
    }

    /**
     * @param string $path
     * @param string $modelName
     * @param array $params
     * @return mixed
     */
    protected function _get(string $path, string $modelName, $params = [])
    {
        $options = [
            'params' => $params,
        ];

        return $this->client->apiRequest('get', $path, new ResponseModelDecorator($modelName), $options);
    }

    /**
     * @param string $path
     * @param string $modelName
     * @param array $data
     * @return mixed
     */
    protected function _put(string $path, string $modelName, array $data)
    {
        $options = [
            'body' => json_encode($data),
            'headers' => ['Content-Type' => 'application/json']
        ];

        return $this->client->apiRequest('put', $path, new ResponseModelDecorator($modelName), $options);
    }

    /**
     * @param string $path
     * @param string $modelName
     * @param array $data
     * @return mixed
     */
    protected function _post(string $path, string $modelName, array $data)
    {
        $options = [
            'body' => json_encode($data),
            'headers' => ['Content-Type' => 'application/json']
        ];

        return $this->client->apiRequest('post', $path, new ResponseModelDecorator($modelName), $options);
    }

    /**
     * @param string $path
     * @param string $modelName
     * @param array $body
     * @param array $params
     * @return mixed
     */
    protected function _patch(string $path, string $modelName, array $body, array $params = [])
    {
        $options = [
            'body' => json_encode($body),
            'headers' => ['Content-Type' => 'application/json'],
            'params' => $params
        ];

        return $this->client->apiRequest('patch', $path, new ResponseModelDecorator($modelName), $options);
    }
}
