<?php
return [

   //用户列表
   'customers' => [
      'id' => '编号',
      'create_at' => '录入时间',
      'name' => '姓名',
      'phone' => '电话',
      'wx' => '微信',
       'sex' => '性别',
       'department' => '部门',
       'certificates'   => '证件号'
   ],

  //授权统计列表
   'auth' => [
     'create_at'   => '登入时间',
     'name'        => '姓名',
       'sex'        => '性别',
       'phone'      => '电话',
       'wx'         => '微信',
       'department' => '部门',
   ],

   //车辆申请列表
    'vehicle' => [
        'create_at' => '申请时间',
        'time'      => '使用时间',
        'status'    => '状态',
        'name'      => '申请人姓名',
        'vehicle_num'   => '用车数量',
        'license_plate' => '车牌号',
        'department'    => '申请部门',
        'cause'         => '事由',
        'approver'      => '审批人',
        'copy_person'   => '抄送人',
    ],

    //办公用品申请列表
    'work' => [
        'create_at' => '申请时间',
        'status'    => '状态',
        'name'      => '申请人姓名',
          'department'    => '申请部门',
        'articles_name'   => '用品名称',
        'approver'      => '审批人',
        'copy_person'   => '抄送人',
    ],

    //会议室使用统计
    'room' => [
        'create_at' => '申请时间',
        'status'    => '状态',
        'name'      => '申请人姓名',
        'time'      => '使用时间',
        'people_num'=> '参会人数',
        'company_name' => '承办单位',
        'room_name' => '会议室名称',
        'company_form'  => '会议室形式',
        'approver'      => '审批人',
        'copy_person'   => '抄送人',
    ],

    //外出申请统计
    'out' => [
        'create_at' => '申请时间',
        'status'    => '状态',
        'name'      => '申请人姓名',
        'out_address'      => '外出地点',
        'time'      => '外出时间',
        'cause'     => '外出事由',
        'approver'  => '审批人',
        'copy_person'=> '抄送人',
    ],

    //请假统计
    'leave' => [
        'create_at' => '申请时间',
        'status'    => '状态',
        'name'      => '申请人姓名',
        'department'    => '申请部门',
        'leave_type'    => '请假类型',
        'time'      => '请假开始时间',
        'cause'         => '事由',
        'approver'  => '审批人',
        'copy_person'=> '抄送人',
    ],

    //值班列表
    'duty' => [
        'create_at' => '值班时间',
        'name'      => '值班人姓名',
        'phone1'    =>  '电话1',
        'phone2'    =>  '电话2',
        'phone3'    =>  '电话3',
        'department'    => '部门',
    ],

    //考勤统计
    'attendance' => [
        'create_at'     => '日期',
        'name'          => '姓名',
        'department'    => '部门',
        'str_time'      => '上班打卡时间',
        'end_time'      => '下班打卡时间',
        'type'          => '当天考勤状态'
    ],

    //补卡统计
    'patch' => [
        'create_at' => '申请时间',
        'status'    => '状态',
        'name'      => '申请人姓名',
        'department'    => '部门',
        'abnormal'    => '补卡时间',
        'patch_status' => '异常状态',
        'approver'  => '审批人',
        'copy_person'=> '抄送人',
    ],

    //图片路径
    'path' => [
        'url' => '/uploads/images/',
    ],
];
