import React, {useEffect, useRef, useState} from 'react';
import {
  Button,
  Card,
  Checkbox,
  Col,
  Divider,
  Form,
  Input,
  InputNumber,
  Menu,
  message,
  Popconfirm,
  Radio,
  Row,
  Space,
  Spin,
  Switch,
  Typography,
} from 'antd';
import {
  DeleteOutlined,
  EditOutlined,
  PlusOutlined,
  ReloadOutlined,
  SaveOutlined,
  SettingOutlined,
} from '@ant-design/icons';
import XinForm from '@/components/XinForm';
import type { XinFormRef } from '@/components/XinForm/typings';
import type { FormColumn } from '@/components/XinFormField/FieldRender/typings';
import {useTranslation} from 'react-i18next';
import type {IConfigGroup} from '@/domain/iConfigGroup.ts';
import type {IConfigItem} from '@/domain/iConfigItem.ts';
import {
  createConfigGroup,
  createConfigItem,
  deleteConfigGroup,
  deleteConfigItem,
  getConfigGroupList,
  getConfigItemList, refreshCache,
  saveConfigItems,
  updateConfigGroup,
  updateConfigItem,
} from '@/api/system/sys_config.ts';

const { TextArea } = Input;
const { Text, Title } = Typography;

const ConfigManagement: React.FC = () => {
  const { t } = useTranslation();

  /** 表单组件类型选项 */
  const FORM_COMPONENT_OPTIONS = [
    { label: t('system.config.component.Input'), value: 'Input' },
    { label: t('system.config.component.TextArea'), value: 'TextArea' },
    { label: t('system.config.component.InputNumber'), value: 'InputNumber' },
    { label: t('system.config.component.Switch'), value: 'Switch' },
    { label: t('system.config.component.Radio'), value: 'Radio' },
    { label: t('system.config.component.Checkbox'), value: 'Checkbox' },
  ];
  const [configGroups, setConfigGroups] = useState<IConfigGroup[]>([]);
  const [selectedGroupId, setSelectedGroupId] = useState<number>();
  const [selectedGroupKey, setSelectedGroupKey] = useState<string>();
  const [configItems, setConfigItems] = useState<IConfigItem[]>([]);
  const [loading, setLoading] = useState(false);
  const [itemsLoading, setItemsLoading] = useState(false);
  const [saving, setSaving] = useState(false);

  // 设置组表单
  const [editingGroup, setEditingGroup] = useState<IConfigGroup | null>(null);
  const groupFormRef = useRef<XinFormRef>(null);

  // 设置项表单
  const [editingItem, setEditingItem] = useState<IConfigItem | null>(null);
  const itemFormRef = useRef<XinFormRef>(null);

  // 设置项值表单
  const [valuesForm] = Form.useForm();

  /** 加载设置组列表 */
  const loadConfigGroups = async () => {
    try {
      setLoading(true);
      const { data } = await getConfigGroupList();
      const groups = data.data || [];
      setConfigGroups(groups);

      // 如果当前没有选中的组,选中第一个
      if (!selectedGroupId && groups.length > 0) {
        setSelectedGroupId(groups[0].id);
        setSelectedGroupKey(groups[0].key);
      }
    } finally {
      setLoading(false);
    }
  };

  /** 加载设置项列表 */
  const loadConfigItems = async (groupId?: number) => {
    if (!groupId) return;

    try {
      setItemsLoading(true);
      const { data } = await getConfigItemList(groupId);
      const items = data.data || [];
      setConfigItems(items);

      // 初始化表单值
      const initialValues: { [key: string]: any } = {};
      items.forEach(item => {
        if(!item.type || ['Input', 'TextArea', 'Radio'].includes(item.type)) {
          initialValues[`item_${item.id}`] = String(item.values);
        }
        if(item.type && item.type === 'InputNumber') {
          initialValues[`item_${item.id}`] = Number(item.values);
        }
        if(item.type && item.type === 'Switch') {
          if(item.values === '0' || item.values === 'false') {
            initialValues[`item_${item.id}`] = false;
          }else {
            initialValues[`item_${item.id}`] = Boolean(item.values);
          }
        }
        if(item.type && item.type === 'Checkbox') {
          try {
            initialValues[`item_${item.id}`] = JSON.parse(item.values || '[]');
          } catch {
            initialValues[`item_${item.id}`] = [];
          }
        }
      });
      console.log(initialValues)
      valuesForm.setFieldsValue(initialValues);
    } finally {
      setItemsLoading(false);
    }
  };

  useEffect(() => {
    loadConfigGroups();
  }, []);

  useEffect(() => {
    if (selectedGroupId) {
      loadConfigItems(selectedGroupId);
    }
  }, [selectedGroupId]);

  /** 打开新增设置组对话框 */
  const handleAddGroup = () => {
    setEditingGroup(null);
    groupFormRef.current?.resetFields();
    groupFormRef.current?.open();
  };

  /** 打开编辑设置组对话框 */
  const handleEditGroup = (group: IConfigGroup) => {
    setEditingGroup(group);
    groupFormRef.current?.setFieldsValue(group);
    groupFormRef.current?.open();
  };

  /** 保存设置组 */
  const handleSaveGroup = async (values: IConfigGroup) => {
    try {
      if (editingGroup) {
        await updateConfigGroup(editingGroup.id!, values);
        message.success(t('system.config.group.updateSuccess'));
      } else {
        await createConfigGroup(values);
        message.success(t('system.config.group.createSuccess'));
      }
      groupFormRef.current?.close();
      await loadConfigGroups();
      return true;
    } catch {
      return false;
    }
  };

  /** 删除设置组 */
  const handleDeleteGroup = async (id: number) => {
    try {
      await deleteConfigGroup(id);
      message.success(t('system.config.group.deleteSuccess'));
      if (selectedGroupId === id) {
        setSelectedGroupId(undefined);
        setSelectedGroupKey(undefined);
      }
      await loadConfigGroups();
    } catch (error) {
      console.error('删除设置组失败:', error);
    }
  };

  /** 打开新增设置项对话框 */
  const handleAddItem = () => {
    setEditingItem(null);
    itemFormRef.current?.resetFields();
    itemFormRef.current?.setFieldsValue({ group_id: selectedGroupId });
    itemFormRef.current?.open();
  };

  /** 打开编辑设置项对话框 */
  const handleEditItem = (item: IConfigItem) => {
    setEditingItem(item);
    itemFormRef.current?.setFieldsValue(item);
    itemFormRef.current?.open();
  };

  /** 保存设置项 */
  const handleSaveItem = async (values: IConfigItem) => {
    try {
      if (editingItem) {
        await updateConfigItem(editingItem.id!, { ...values, group_id: selectedGroupId });
        message.success(t('system.config.item.updateSuccess'));
      } else {
        await createConfigItem({ ...values, group_id: selectedGroupId });
        message.success(t('system.config.item.createSuccess'));
      }
      itemFormRef.current?.close();
      await loadConfigItems(selectedGroupId);
      return true;
    } catch {
      return false;
    }
  };

  /** 删除设置项 */
  const handleDeleteItem = async (id: number) => {
    try {
      await deleteConfigItem(id);
      message.success(t('system.config.item.deleteSuccess'));
      await loadConfigItems(selectedGroupId);
    } catch (error) {
      console.error('删除设置项失败:', error);
    }
  };

  /** 批量保存所有设置项值 */
  const handleSaveAll = async () => {
    try {
      setSaving(true);
      const values = valuesForm.getFieldsValue();
      const configs = configItems.map(item => {
        const value = values[`item_${item.id}`];
        if(!item.type || ['Input', 'TextArea', 'Radio'].includes(item.type)) {
          return { id: item.id!, value: String(value) };
        }
        if(item.type && item.type === 'InputNumber') {
          return { id: item.id!, value: String(value) };
        }
        if(item.type && item.type === 'Switch') {
          if(value === '0' || value === 'false' || !!value) {
            return { id: item.id!, value: 'false' };
          }else {
            return { id: item.id!, value: 'true' };
          }
        }
        if(item.type && item.type === 'Checkbox') {
          return { id: item.id!, value: JSON.stringify(value) };
        }
        return { id: item.id!, value: value };
      });
      await saveConfigItems(configs);
      message.success(t('system.config.item.updateSuccess'));
    } finally {
      setSaving(false);
    }
  };

  const handleRefresh = async () => {
    try {
      setSaving(true);
      await refreshCache();
      message.success(t('system.config.item.refreshCacheSuccess'))
    } finally {
      setSaving(false);
    }
  }

  /** 渲染设置项的表单组件 */
  const renderConfigItemComponent = (item: IConfigItem) => {
    const fieldName = `item_${item.id}`;
    const componentType = item.type || 'Input';
    const usage = `site_config('${selectedGroupKey}.${item.key}')`;

    // 解析options
    let options: any[] = [];
    if (item.options_json) {
      try {
        options = JSON.parse(item.options_json);
      } catch {
        console.error('options解析失败:', item.options_json);
      }
    }

    // 解析props
    let componentProps: any = {};
    if (item.props_json) {
      try {
        componentProps = JSON.parse(item.props_json);
      } catch {
        console.error('props解析失败:', item.props_json);
      }
    }

    // 自定义Label组件
    const CustomLabel = () => (
      <div style={{ marginBottom: 8 }}>
        <Space>
          <Text strong>{item.title}</Text>
          <Button
            type="text"
            size="small"
            icon={<EditOutlined />}
            onClick={() => handleEditItem(item)}
          />
          <Popconfirm
            title={t('system.config.item.deleteConfirm')}
            onConfirm={() => handleDeleteItem(item.id!)}
            okText={t('system.config.confirm.ok')}
            cancelText={t('system.config.confirm.cancel')}
          >
            <Button
              type="text"
              size="small"
              danger
              icon={<DeleteOutlined />}
            />
          </Popconfirm>
        </Space>
        <div style={{ marginBottom: 4 }}>
          <Text type="secondary" style={{ fontSize: 12 }}>
            {item.describe} <Text code copyable>{usage}</Text>
          </Text>
        </div>
      </div>
    );

    let component;
    switch (componentType) {
      case 'Input':
        component = (
          <Input
            placeholder={item.describe || t('system.config.form.placeholder.input')}
            {...componentProps}
          />
        );
        break;
      case 'TextArea':
        component = (
          <TextArea
            placeholder={item.describe || t('system.config.form.placeholder.input')}
            rows={4}
            {...componentProps}
          />
        );
        break;
      case 'InputNumber':
        component = (
          <InputNumber
            style={{ width: '100%' }}
            placeholder={item.describe || t('system.config.form.placeholder.input')}
            {...componentProps}
          />
        );
        break;
      case 'Switch':
        component = <Switch {...componentProps} />;
        break;
      case 'Radio':
        component = <Radio.Group options={options} {...componentProps} />;
        break;
      case 'Checkbox':
        component = <Checkbox.Group options={options} {...componentProps} />;
        break;
      default:
        component = <Input placeholder={item.describe || t('system.config.form.placeholder.input')} {...componentProps} />;
    }

    return (
      <div style={{ marginBottom: 24 }}>
        <CustomLabel />
        <Form.Item name={fieldName} noStyle>
          {component}
        </Form.Item>
      </div>
    );
  };

  /** 设置组表单列 */
  const groupColumns: FormColumn<IConfigGroup>[] = [
    {
      title: t('system.config.group.field.title'),
      dataIndex: 'title',
      valueType: 'text',
      rules: [{ required: true, message: t('system.config.group.field.title.required') }],
    },
    {
      title: t('system.config.group.field.key'),
      dataIndex: 'key',
      valueType: 'text',
      rules: [{ required: true, message: t('system.config.group.field.key.required') }],
    },
    {
      title: t('system.config.group.field.remark'),
      dataIndex: 'remark',
      valueType: 'textarea',
      colProps: {span: 24},
    },
  ];

  /** 设置项表单列 */
  const itemColumns: FormColumn<IConfigItem>[] = [
    {
      title: t('system.config.item.field.key'),
      dataIndex: 'key',
      valueType: 'text',
      rules: [{ required: true, message: t('system.config.item.field.key.required') }],
    },
    {
      title: t('system.config.item.field.title'),
      dataIndex: 'title',
      valueType: 'text',
      rules: [{ required: true, message: t('system.config.item.field.title.required') }],
    },
    {
      title: t('system.config.item.field.type'),
      dataIndex: 'type',
      valueType: 'select',
      fieldProps: {
        options: FORM_COMPONENT_OPTIONS,
      },
      rules: [{ required: true, message: t('system.config.item.field.type.required') }],
    },
    {
      title: t('system.config.item.field.sort'),
      dataIndex: 'sort',
      valueType: 'digit',
      initialValue: 0
    },
    {
      title: t('system.config.item.field.describe'),
      dataIndex: 'describe',
      valueType: 'textarea',
      colProps: { span: 24 },
    },
    {
      title: t('system.config.item.field.options'),
      dataIndex: 'options',
      valueType: 'textarea',
      tooltip: t('system.config.item.field.options.tooltip'),
    },
    {
      title: t('system.config.item.field.props'),
      dataIndex: 'props',
      valueType: 'textarea',
      tooltip: t('system.config.item.field.props.tooltip'),
    },
    {
      title: t('system.config.item.field.values'),
      dataIndex: 'values',
      valueType: 'text',
    },
  ];

  return (
    <>
      <div className={'mb-5'}>
        <Title level={3}>{t('system.config.page.title')}</Title>
        <Text type="secondary">{t('system.config.page.description')}</Text>
      </div>
      <Row gutter={[16, 16]}>
        {/* 左侧设置组菜单 */}
      <Col xs={24} lg={4}>
        <Card
          styles={{
            header: { paddingInline: 16, paddingBlock: 0, minHeight: 48 },
            body: { padding: 16, minHeight: 52 },
          }}
          title={(
            <Space>
              <SettingOutlined />
              {t('system.config.group.title')}
            </Space>
          )}
          extra={
            <Button
              type="link"
              size="small"
              icon={<PlusOutlined />}
              onClick={handleAddGroup}
            >
              {t('system.config.group.add')}
            </Button>
          }
          loading={loading}
        >
          <Menu
            mode="inline"
            selectedKeys={selectedGroupId ? [String(selectedGroupId)] : []}
            items={configGroups.map(group => ({
              key: String(group.id),
              label: (
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                  <span>{group.title}</span>
                  <Space size="small">
                    <Button
                      type="text"
                      size="small"
                      icon={<EditOutlined />}
                      onClick={(e) => {
                        e.stopPropagation();
                        handleEditGroup(group);
                      }}
                    />
                    <Popconfirm
                      title={t('system.config.group.deleteConfirm')}
                      description={t('system.config.group.deleteWarning')}
                      onConfirm={(e) => {
                        e?.stopPropagation();
                        handleDeleteGroup(group.id!);
                      }}
                      okText={t('system.config.confirm.ok')}
                      cancelText={t('system.config.confirm.cancel')}
                    >
                      <Button
                        type="text"
                        size="small"
                        danger
                        icon={<DeleteOutlined />}
                        onClick={(e) => e.stopPropagation()}
                      />
                    </Popconfirm>
                  </Space>
                </div>
              ),
              onClick: () => {
                setSelectedGroupId(group.id);
                setSelectedGroupKey(group.key);
              },
            }))}
          />
        </Card>
      </Col>

      {/* 右侧设置项 */}
      <Col xs={24} lg={20}>
        <Card
          styles={{
            header: { paddingInline: 16, paddingBlock: 0, minHeight: 48 },
            body: { padding: 16, minHeight: 52 },
          }}
          title={t('system.config.item.title')}
          extra={
            selectedGroupId && (
              <Space>
                <Button
                  type="primary"
                  icon={<ReloadOutlined />}
                  onClick={handleRefresh}
                >
                  {t('system.config.refresh.button')}
                </Button>
                <Button
                  type="primary"
                  icon={<SaveOutlined />}
                  loading={saving}
                  onClick={handleSaveAll}
                >
                  {t('system.config.save.button')}
                </Button>
                <Button
                  type="primary"
                  icon={<PlusOutlined />}
                  onClick={handleAddItem}
                >
                  {t('system.config.item.add')}
                </Button>
              </Space>
            )
          }
        >
          {!selectedGroupId ? (
            <div style={{ textAlign: 'center', padding: '60px 0', color: '#999' }}>
              {t('system.config.item.selectGroup')}
            </div>
          ) : (
            <Spin spinning={itemsLoading}>
              <Form form={valuesForm} layout="vertical">
                {configItems.length === 0 ? (
                  <div style={{ textAlign: 'center', padding: '60px 0', color: '#999' }}>
                    {t('system.config.item.empty')}
                  </div>
                ) : (
                  configItems.map((item, index) => (
                    <div key={item.id} style={{ position: 'relative' }}>
                      <div style={{ paddingRight: 80 }}>
                        {renderConfigItemComponent(item)}
                      </div>
                      {index < configItems.length - 1 && <Divider />}
                    </div>
                  ))
                )}
              </Form>
            </Spin>
          )}
        </Card>
      </Col>

      {/* 设置组表单弹窗 */}
      <XinForm<IConfigGroup>
        formRef={groupFormRef}
        layoutType="ModalForm"
        columns={groupColumns}
        onFinish={handleSaveGroup}
        modalProps={{
          title: editingGroup ? t('system.config.group.edit') : t('system.config.group.create'),
          onCancel: () => groupFormRef.current?.close(),
          forceRender: true,
          width: 800
        }}
        grid
        layout={'vertical'}
        colProps={{span: 8}}
        rowProps={{gutter: [30, 0]}}
        trigger={<span style={{display: 'none'}} />}
      />

      {/* 设置项表单弹窗 */}
      <XinForm<IConfigItem>
        formRef={itemFormRef}
        layoutType="ModalForm"
        columns={itemColumns}
        onFinish={handleSaveItem}
        grid={true}
        colProps={{ span: 12 }}
        rowProps={{gutter: 30}}
        layout={'vertical'}
        modalProps={{
          title: editingItem ? t('system.config.item.edit') : t('system.config.item.create'),
          onCancel: () => itemFormRef.current?.close(),
          forceRender: true,
          width: 800,
        }}
        trigger={<span style={{display: 'none'}} />}
      />
    </Row>
  </>
  );
};

export default ConfigManagement;
