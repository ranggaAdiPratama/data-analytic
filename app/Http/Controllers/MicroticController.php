<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use RouterOS\Client;
use RouterOS\Query;

class MicroticController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'host' => '103.118.175.82',
            'user' => 'monitor_stb',
            'pass' => 'Joseph12345!',
            'port' => 8042,
        ]);
    }

    public function interfaceById($id)
    {
        try {
            $query = (new Query('/interface/monitor-traffic'))
                ->equal('interface', $id)
                ->equal('duration', '1s');

            $response = $this->client->query($query)->read();

            return $response;
        } catch (Exception $e) {
            if (env('APP_APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function interfaceEthernetList()
    {
        try {
            $response = $this->client->query('/interface/ethernet/print')->read();

            return $response;
        } catch (Exception $e) {
            if (env('APP_APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function interfaceList()
    {
        try {
            $response = $this->client->query('/interface/list/print')->read();

            return $response;
        } catch (Exception $e) {
            if (env('APP_APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function interfaceWirelessList()
    {
        try {
            $response = $this->client->query('/interface/wireless/print')->read();

            return $response;
        } catch (Exception $e) {
            if (env('APP_APP_DEBUG') == true) {
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
            if (env('APP_APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function ipDhcpClientList()
    {
        try {
            $response = $this->client->query('/ip/dhcp-client/print')->read();

            return $response;
        } catch (Exception $e) {
            if (env('APP_APP_DEBUG') == true) {
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
            if (env('APP_APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }

    public function ipFirewallsList()
    {
        try {
            $response = $this->client->query('/ip/firewall/filter/print')->read();

            return $response;
        } catch (Exception $e) {
            if (env('APP_APP_DEBUG') == true) {
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
            if (env('APP_APP_DEBUG') == true) {
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
            if (env('APP_APP_DEBUG') == true) {
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
            if (env('APP_APP_DEBUG') == true) {
                dd($e);
            }

            return apiResponse($e->getMessage(), 500, $e);
        }
    }
}
