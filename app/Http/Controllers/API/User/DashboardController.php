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
use App\Notifications\Notify_Community_Member;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;


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
    public function showCommunity($comm_ID, $id = null)
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
        'Created_by' => User::where('id', $community->created_by)->value('name'),
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

                if($member->user_id){
                    $flights = User::where('id', $member->user_id)->get();
                    foreach($flights as $userData){
                        $ChannelmemberItem['Name'] = $userData->name;
                    }
                }
                $channelItem['Members'][] = $ChannelmemberItem;
            }

        $communityItem['Channels'][] = $channelItem;
    }

    $communitiesData[] = $communityItem;
}
            //-----------End Trial-----------


        }else{
                //---------------Add session value of created by (Admin)
            $data = User::where('id',$comm_ID)->
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
            'ID of USer' => $comm_ID,
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

            /**z
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
            'submit'=> 'Channel Created'
        ],201);
    }



    public function Channel_Add_Member(Request $request)
    {

        $users = $request->all();
        $userActiveArray = [];
    foreach ($users as $user) {
        $userActive = [
            'id' => $user['user_id'],
            'channel_ID'=> $user['channel_id'],

        ];

        $Channel = Channel::find($user['channel_id']);
        $channel_Member = new ChannelMember();
        $channel_Member->user_id = $user['user_id'];
        $Channel->members()->save($channel_Member);
    }
         return response([
            'Data' => $request->all(),
            'submit'=> 'Channel Created'
        ],201);
    }




    // getCommunityMember
      /**
     * Show Community Detail is register the community by User.
     * this funtion use to add member in community and add memnber in chanel based on condition.
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



      /**
     * Show Community Detail is register the community by User.
     * this funtion use to add member in community and add memnber in chanel based on condition.
     */
    public function get_FrstCommunity_Created_Member($id)
    {

        $id = [$id];
        $data = User::select("id",'name','email')
        ->whereNotIn('id', $id)
        ->take(10)
        ->get();

        return response([
            'Data' => $data,
            // 'selected' => $flights,
        ], 200);
    }

//-------------------Notification---------------


    public function notification(Request $request)
    {
        $users = $request->all();
        $userActiveArray = [];
    foreach ($users as $user) {
        $userActive = [
            'From' => $user['created_by'],
            'Community_Name' => $user['community_Name'],
            'Community_ID' => $user['community_ID'],
            'channel_Name' => $user['channel_Name'],
            'channel_ID' => $user['channel_ID'],
            'email' => $user['email'],
            'id' => $user['user_id'],
            'Role' => $user['role'],
            'showText' => 'We invite you to join us.',
        ];
        $userActiveArray[] = $userActive;
        Notification::route('mail', $user['email'])
        ->notify(new Notify_Community_Member($userActive));
        $community = Community::find($user['community_ID']);
        if ($community) {
            $community_member = new CommunityMember();
            $community_member->role = $user['role'];
            $community_member->user_id = $user['user_id'];
            $community_member->status = 'Pending';
            $community->members()->save($community_member);
        }
    }
        return response([
            'Data' => $userActiveArray,
        ], 200);
    }



    public function Notifications_User($user_id,$comm_ID, $ch_ID){

        $userIds = []; // Initialize an empty array to store user_ids
        $auth = [];

        $users = CommunityMember::select("status")->where('user_id', $user_id)
        ->where('communitie_id', $comm_ID)
        ->get();



        foreach ($users as $users) {
            if ($users->status == 'Active') {
                $channel_Members = Channel::find($ch_ID)->members()->get();

        }
        }





        return response([
            'User_ID' => $users,
            // 'Community_ID' => $users->status,
            'Channel_ID' => $channel_Members,

        ], 200);
    }


}







        //-----------End Trial-----------
