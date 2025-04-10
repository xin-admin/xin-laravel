import { GithubOutlined } from '@ant-design/icons';
import { DefaultFooter, ProLayoutProps } from '@ant-design/pro-components';
import React from 'react';

/**
 * 页面底部渲染
 * @constructor
 */
const Footer: ProLayoutProps['footerRender'] = () => {

  const currentYear = new Date().getFullYear();

  return (
    <>
      <DefaultFooter
        copyright={`${currentYear} Xin Admin`}
        style={{background: 'transparent'}}
        links={[
          {
            key: 'Ant Design Pro',
            title: 'Ant Design Pro',
            href: 'https://pro.ant.design',
            blankTarget: true,
          },
          {
            key: 'github',
            title: <GithubOutlined />,
            href: 'https://github.com/ant-design/ant-design-pro',
            blankTarget: true,
          },
          {
            key: 'Ant Design',
            title: 'Ant Design',
            href: 'https://ant.design',
            blankTarget: true,
          },
        ]}
      />
    </>

  );
};

export default Footer;
