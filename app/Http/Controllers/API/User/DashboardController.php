<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Community;
use App\Models\Channel;
use App\Models\CommunityMember;
use App\Models\ChannelMember;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

      /**
     * AddCommunity is register the community by User.
     */
    public function addCommunity(Request $request,$id)
    {
        $user = User::find($id);
        $community = new Community();
        $community->name = $request->name;
        $community->description = $request->description;
       $data =  $user->community()->save($community);

         return response([
            'Data' => $data,
            'submit'=> 'Data aata he'
        ],201);
    }

       /**
     * Show Community Detail is register the community by User.
     */
    public function showCommunity($id = null)
    {
        $communitiesData = [];

        if($id != null){

            $communityData = Community::where('id',$id)->
            with(['members','channel', 'channel.members' ])->
            get();
            //----------__Trial--------------


foreach ($communityData as $community) {
    $communityItem = [
        'id' => $community->id,
        'Name' => $community->name,
        'Description' => $community->description,
        'CommunityMembers' => [],
        'Channels' => [],
    ];

    foreach ($community->members as $commMember) {
        $memberItem = [
            'ID' => $commMember->id,
            'Role' => $commMember->role,
            'Status' => $commMember->status,
            'user_ID' => $commMember->user_id,
        ];
        if($commMember->user_id){
            $flights = User::where('id', $commMember->user_id)->get();
            foreach($flights as $userData){
                $memberItem['Name'] = $userData->name;
            }
        }


        $communityItem['CommunityMembers'][] = $memberItem;
    }


    foreach ($community->channel as $channel) {
        $channelItem = [
            'ChannelID' => $channel->id,
            'ChannelName' => $channel->name,
            'Members' => [],
        ];

        foreach ($channel->members as $member) {
            $ChannelmemberItem = [
                'user_ID' => $member->user_id,
            ];
            if($commMember->user_id){
                $flights = User::where('id', $member->user_id)->get();
                foreach($flights as $userData){
                    $ChannelmemberItem['Name'] = $userData->name;
                }
            }
        }

        $channelItem['Members'][] = $ChannelmemberItem;
        $communityItem['Channels'][] = $channelItem;
    }

    $communitiesData[] = $communityItem;
}
            //-----------End Trial-----------


        }else{

            $data = User::where('id',1)->
            with(['community', 'community.members', 'community.channel','community.channel.members'])
            ->get();

            foreach ($data as $user) {
                    $communities = $user->community;

                    foreach ($communities as $community) {
                        $communityData = [
                            'id'=>  $community->id,
                            'Name' => $community->name,
                            'Description' => $community->description,
                            'Members' => $community->members->flatten()->count(),
                            'Channels' => $community->channel->flatten()->count(),
                        ];

                        $communitiesData[] = $communityData;
                    }
                }
        }

      return response([
            'community' => $communitiesData,

        ],201);



    }



           /**
     * AddCommunity is register the community by User.
     */
    public function communityMember($Cmtid,$chID)
    {
        $community = Community::find($Cmtid);
        $CommunityMember = new CommunityMember();
        $CommunityMember->user_id = 3;
        $CommunityMember->role = "Team Leader";
        $CommunityMember->status = "Pending";
        $community->members()->save($CommunityMember);

        $channel = Channel::find($chID);
        $channelMember = new ChannelMember();
        $channelMember->user_id = 3;
        $channel->members()->save($channelMember);

        $data = [
            'Channel ID' => $community,
            'channel_ID:' => $chID,

        ];
        return $data;

        //  return response([
        //     // 'Data' => $request->all(),
        //     'submit'=> 'Data aata he'
        // ],201);
    }

            /**
     * AddCommunity is register the community by User.
     */
    public function addChannel(Request $request,$id)
    {
        $community = Community::find($id);
        $channel = new Channel();

        $channel->name = $request->name;
        $channel->created_by = $community->created_by;
        $channel = $community->channel()->save($channel);

         return response([
            'Data' => $channel,
            'submit'=> 'Data aata he'
        ],201);
    }



    // getCommunityMember
      /**
     * Show Community Detail is register the community by User.
     */
    public function getCommunityMember($user_id,$comm_ID)
    {
        $userIds = []; // Initialize an empty array to store user_ids
        $auth = [];



            $data = Community::select('id')
                    ->where('created_by', $user_id)
                    ->where('id', $comm_ID)
                    ->with('members')
                    ->get();

                    foreach ($data as $community) {
                        foreach ($community->members as $member) {
                            $userIds[] = $member->user_id;
                        }
                    }
                    array_push($userIds,(int)$user_id);

                    $users = User::select("*")
                    ->whereNotIn('id', $userIds)
                    ->get();



        return response([
            'Data' => $userIds,
            "not in" => $users,
            // 'data is ' => $data,
            // "auth" => Auth::user(),
        ], 200);
        // $user = User::with('communities.members')->find($user_id);

    }


}




