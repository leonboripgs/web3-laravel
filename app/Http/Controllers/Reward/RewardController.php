<?php

namespace App\Http\Controllers\Reward;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Http\Controllers\Reward\Keccak;
// use App\Http\Controllers\Reward\AbiEncoder;
use Web3\Utils;
use Web3\Contracts\Ethabi;
use Web3\Contracts\Types\Address;
use Web3\Contracts\Types\Boolean;
use Web3\Contracts\Types\Bytes;
use Web3\Contracts\Types\DynamicBytes;
use Web3\Contracts\Types\Integer;
use Web3\Contracts\Types\Str;
use Web3\Contracts\Types\Uinteger;

// namespace phpseclib\Math;
use phpseclib\Math\BigInteger;

class RewardController extends Controller
{
    protected $abi;

    public function __constructor()
    {
        $this->abi = new Ethabi([
            'address' => new Address,
            'bool' => new Boolean,
            'bytes' => new Bytes,
            'dynamicBytes' => new DynamicBytes,
            'int' => new Integer,
            'string' => new Str,
            'uint' => new Uinteger
        ]);
    }

    /**
     * 
     *
     * @param  
     * @return 
     */
    public function getReward(Request $request)
    {
        $abi = new Ethabi([
            'address' => new Address,
            'bool' => new Boolean,
            'bytes' => new Bytes,
            'dynamicBytes' => new DynamicBytes,
            'int' => new Integer,
            'string' => new Str,
            'uint' => new Uinteger
        ]);;
        $rewardAmount = rand(1, 100);   // This might be replaced to logic for calculating rewards.
        $amount = Utils::toWei(strval($rewardAmount),"ether");
        $hashTime = time();
        $abiEncoded = $abi->encodeParameters(['uint256', 'uint256', 'bytes32'], [$amount->toHex(), $hashTime, '0x48656c6c6f20576f726c64000000000000000000000000000000000000000000' ]);
        $hash = Keccak::hash(hex2bin(substr($abiEncoded, 2)), 256);
        return response()->json([
            'amount' => $rewardAmount,
            'timestamp' => $hashTime,
            'hash' => $hash
        ]);
    }
}
