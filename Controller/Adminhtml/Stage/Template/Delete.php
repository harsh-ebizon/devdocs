<?php

namespace Gene\BlueFoot\Controller\Adminhtml\Stage\Template;

/**
 * Class Delete
 *
 * @package Gene\BlueFoot\Controller\Adminhtml\Stage\Widget
 *
 * @author Dave Macaulay <dave@gene.co.uk>
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;

    /**
     * @var \Gene\BlueFoot\Model\Stage\TemplateFactory
     */
    protected $_template;

    /**
     * Delete constructor.
     *
     * @param \Magento\Framework\App\Action\Context            $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Gene\BlueFoot\Model\Stage\TemplateFactory       $templateFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Gene\BlueFoot\Model\Stage\TemplateFactory $templateFactory
    ) {
        parent::__construct($context);

        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_template = $templateFactory;
    }

    /**
     * Allow a user to delete a template
     *
     * @return $this
     */
    public function execute()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $template = $this->_template->create()->load($id);
            if ($template) {
                try {
                    $template->delete();
                    return $this->_resultJsonFactory->create()->setData(['success' => true]);
                } catch (\Exception $e) {
                    return $this->_resultJsonFactory->create()->setData(['success' => false, 'exception' => $e->getMessage()]);
                }
            }
        }

        return $this->_resultJsonFactory->create()->setData(['success' => false]);
    }

}