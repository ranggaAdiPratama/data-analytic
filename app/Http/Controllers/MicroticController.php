<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RouterOS\Client;
use RouterOS\Query;

class MicroticController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'host' => '191.101.190.202',
            'user' => 'monitor_stb',
            'pass' => 'Joseph12345!',
            'port' => 8042,
        ]);
    }

    public function bandwidth()
    {
        try {
            $interface = request()->has('interface') && strlen(request()->has('interface')) > 0 ? request()->interface : 'ether1';

            $data = [];

            $response = $this->client->query('/interface/print')->read();

            foreach ($response as $record) {
                if ($record['name'] == $interface) {
                    $data[] = [
                        'timestamp' => $record['last-link-up-time'],
                        'tx_byte' => $record["tx-byte"],
                        'rx_byte' => $record["rx-byte"]
                    ];
                }
            }

            return $data;
        } catch (Exception $e) {
            if (env('APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function interfaceList($id)
    {
        try {
            $router = DB::table('routers')
                ->where('id', $id)
                ->first();

            $client = new Client([
                'host' => $router->host,
                'user' => $router->username,
                'pass' => $router->pass,
                'port' => $router->port,
            ]);

            $response = $this->client->query('/interface/print')->read();

            $data = [];

            foreach ($response as $row) {
                $data[] = [
                    'name'      => $row['name'],
                    'rx_byte'   => $row['rx-byte'],
                    'tx_byte'   => $row['tx-byte']
                ];
            }

            return $data;
        } catch (Exception $e) {
            dd($e);
            if (env('APP_DEBUG') == true) {
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function interfaceEthernetList($id)
    {
        try {
            $router = DB::table('routers')
                ->where('id', $id)
                ->first();

            $client = new Client([
                'host' => $router->host,
                'user' => $router->username,
                'pass' => $router->pass,
                'port' => $router->port,
            ]);

            $response = $client->query('/interface/ethernet/print')->read();

            $data = [];

            foreach ($response as $row) {
                $data[] = [
                    'name'  => $row['name']
                ];
            }

            return $data;
        } catch (Exception $e) {
            if (env('APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function ipAddressList()
    {
        try {
            $response = $this->client->query('/ip/address/print')->read();

            return $response;
        } catch (Exception $e) {
            if (env('APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function ipDhcpServerList()
    {
        try {
            $response = $this->client->query('/ip/dhcp-server/print')->read();

            return $response;
        } catch (Exception $e) {
            if (env('APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function ipKidControlList()
    {
        try {
            // $response = $this->client->query('/ip/firewall/address-list/print')->read();

            // $query = (new Query('/ip/firewall/address-list/print'));
            $query = (new Query('/ip/kid-control/device/print'));
            // ->where('list', 'kid-control');

            $response = $this->client->query($query)->read();

            return $response;
        } catch (Exception $e) {
            if (env('APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function ipRoutesList()
    {
        try {
            $response = $this->client->query('/ip/route/print')->read();

            return $response;
        } catch (Exception $e) {
            if (env('APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function logList(Request $request)
    {
        try {
            $response = $this->client->query('/log/print')->read();

            $data = [];

            if (strlen($request->ethernet) > 0) {
                foreach ($response as $row) {
                    $message = $row['message'];

                    $ip = null;

                    $logInterface = null;

                    if (strpos($message, $request->ethernet) !== false) {
                        if (!preg_match('/to \[(http[s]?:\/\/[^\]]+)\]/', $message, $matches)) {
                            continue;
                        }

                        $data[] = [
                            ".id"   => $row['.id'],
                            "time"  => $row['time'],
                            'url'   => $matches[1]
                        ];
                    } else {
                        continue;
                    }
                }
            } else {
                foreach ($response as $row) {
                    $message = $row['message'];

                    if (preg_match('/to \[(http[s]?:\/\/[^\]]+)\]/', $message, $matches)) {
                        $data[] = [
                            ".id"   => $row['.id'],
                            "time"  => $row['time'],
                            'url'   => $matches[1]
                        ];
                    } else {
                        continue;
                    }
                }
            }

            return $data;
        } catch (Exception $e) {
            if (env('APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function systemResources()
    {
        try {
            $response = $this->client->query('/system/resource/print')->read();

            return $response;
        } catch (Exception $e) {
            if (env('APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function topHostName($id)
    {
        try {
            $router = DB::table('routers')
                ->where('id', $id)
                ->first();

            $client = new Client([
                'host' => $router->host,
                'user' => $router->username,
                'pass' => $router->pass,
                'port' => $router->port,
            ]);

            $response = $client->query('/ip/kid-control/device/print')->read();

            $data = [];

            foreach ($response as $row) {
                $data[] = [
                    'id'            => $row['.id'],
                    'name'          => strlen($row['name']) > 0 ? $row['name'] : $row['ip-address'],
                    'bytes_down'    => $row['bytes-down']
                ];
            }

            return $data;
        } catch (Exception $e) {
            dd($e);
            if (env('APP_DEBUG') == true) {
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }
}
