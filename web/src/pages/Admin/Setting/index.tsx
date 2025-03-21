import React, { useEffect } from 'react';
import { BetaSchemaForm, ProCard, ProFormColumnsType, ProFormInstance } from '@ant-design/pro-components';
import { useModel } from '@umijs/max';
import { useRef } from 'react';
import { updateAdmin } from '@/services/admin';
import { message } from 'antd';
import {editApi} from "@/services/common/table";
import UploadImgItem from '@/components/Xin/XinForm/UploadImgItem';
interface ResponseAdminList {
  id?: number;
  username?: string;
  nickname?: string;
  avatar?: string;
  avatar_url?: string;
  email?: string;
  mobile?: string;
  status?: number;
  group_id?: number;
  sex?: number;
  created_at?: string;
  updated_at?: string;
}


const Table: React.FC = () => {

  let userInfo = useModel('userModel', (model) => {
    return model.userInfo;
  });

  const formRef = useRef<ProFormInstance>();
  useEffect(() => {
    if(userInfo) {
      formRef.current?.setFieldsValue({
        username: userInfo.username,
        nickname: userInfo.nickname,
        email: userInfo.email,
        mobile: userInfo.mobile,
        avatar_url: userInfo.avatar_url,
        avatar_id: userInfo.avatar_id
      })
    }
  },[])

  const columns: ProFormColumnsType<ResponseAdminList>[] = [
    {
      title: '用户名',
      dataIndex: 'username',
      valueType: 'text',
      formItemProps: { rules: [{ required: true, message: '该项为必填' }]},
      fieldProps: { disabled: true},
      colProps: { md: 7 },
    },
    {
      title: '昵称',
      dataIndex: 'nickname',
      valueType: 'text',
      formItemProps: { rules: [{ required: true, message: '该项为必填' }] },
      colProps: { md: 7 },
    },
    {
      title: '邮箱',
      dataIndex: 'email',
      valueType: 'text',
      formItemProps: { rules: [{ required: true, message: '该项为必填' }] },
      colProps: { md: 6 },
    },
    {
      title: '手机号',
      dataIndex: 'mobile',
      valueType: 'text',
      formItemProps: { rules: [{ required: true, message: '该项为必填' }] },
      colProps: { md: 6 },
    },
    {
      title: '头像',
      dataIndex: 'avatar_id',
      valueType: 'avatar',
      formItemProps: { rules: [{ required: true, message: '该项为必填' }] },
      renderFormItem: (schema, config, form) => {
        return <UploadImgItem
          form={form}
          dataIndex={'avatar_id'}
          api={'/admin/uploadAvatar'}
          defaultFile={form.getFieldValue('avatar_url')}
          crop={true}
        />
      },
      colProps: {md: 12,},
    },
  ];
  const submit = async (value: any) => {
    await updateAdmin(value)
    message.success('更新成功')
  }

  const columnsPws: ProFormColumnsType<any>[] = [
    {
      title: '旧密码',
      dataIndex: 'oldPassword',
      valueType: 'password',
      formItemProps: { rules: [{required: true,message: '该项为必填'}] }
    },
    {
      title: '密码',
      dataIndex: 'newPassword',
      valueType: 'password',
      formItemProps: { rules: [{required: true,message: '该项为必填'}] }
    },
    {
      title: '确认密码',
      dataIndex: 'rePassword',
      valueType: 'password',
      formItemProps: { rules: [
          {required: true,message: '该项为必填'},
          ({ getFieldValue }) => ({
            validator(_, value) {
              if (!value || getFieldValue('newPassword') === value) {
                return Promise.resolve();
              }
              return Promise.reject(new Error('两次输入的密码不同'));
            },
          }),
        ]
      }
    },
  ]

  /**
   * 更新节点
   * @param fields
   */
  const defaultUpdate = async (fields: any) => {
    await editApi('/admin/updatePassword', fields)
    message.success('更新成功！');
  }

  return (
    <>
      <ProCard title={'用户基本信息'} headerBordered style={{marginBottom: 10}}>
        <BetaSchemaForm<ResponseAdminList>
          columns={columns}
          layoutType={'Form'}
          formRef={formRef}
          onFinish={ submit }
        />
      </ProCard>
      <ProCard title={'密码修改'} headerBordered>
        <BetaSchemaForm
          title={'修改管理员密码'}
          layoutType={'Form'}
          rowProps={{
            gutter: [16, 16],
          }}
          colProps={{
            span: 24,
          }}
          grid={ true }
          onFinish={ defaultUpdate }
          columns= { columnsPws }
        />
      </ProCard>
    </>
  );

};

export default Table;
