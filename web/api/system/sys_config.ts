import createAxios from '@/utils/request';
import type { IConfigGroup } from '@/domain/iConfigGroup.ts';
import type { IConfigItem } from '@/domain/iConfigItem.ts';

/** 获取设置组列表 */
export async function getConfigGroupList() {
  return createAxios<IConfigGroup[]>({
    url: '/system/config/group',
    method: 'get',
  });
}

/** 新增设置组 */
export async function createConfigGroup(data: IConfigGroup) {
  return createAxios({
    url: '/system/config/group',
    method: 'post',
    data,
  });
}

/** 更新设置组 */
export async function updateConfigGroup(id: number, data: IConfigGroup) {
  return createAxios({
    url: `/system/config/group/${id}`,
    method: 'put',
    data,
  });
}

/** 删除设置组 */
export async function deleteConfigGroup(id: number) {
  return createAxios({
    url: `/system/config/group/${id}`,
    method: 'delete',
  });
}

/** 获取设置项列表 */
export async function getConfigItemList(group_id?: number) {
  return createAxios<IConfigItem[]>({
    url: '/system/config/items',
    method: 'get',
    params: { group_id },
  });
}

/** 新增设置项 */
export async function createConfigItem(data: IConfigItem) {
  return createAxios<IConfigItem>({
    url: '/system/config/items',
    method: 'post',
    data,
  });
}

/** 更新设置项 */
export async function updateConfigItem(id: number, data: IConfigItem) {
  return createAxios<IConfigItem>({
    url: `/system/config/items/${id}`,
    method: 'put',
    data,
  });
}

/** 删除设置项 */
export async function deleteConfigItem(id: number) {
  return createAxios({
    url: `/system/config/items/${id}`,
    method: 'delete',
  });
}

/** 批量保存设置项值 */
export async function saveConfigItems(configs: { id: number; value: string }[]) {
  return createAxios({
    url: '/system/config/items/save',
    method: 'put',
    data: { configs },
  });
}

/** 刷新设置缓存 */
export async function refreshCache() {
  return createAxios({
    url: '/system/config/items/refreshCache',
    method: 'post'
  });
}
