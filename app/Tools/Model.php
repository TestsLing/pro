<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-04-11
 * Time: 09:36
 */

namespace App\Tools;

use App\Models\AdeptTagModel;
use App\Models\ArticleTagModel;
use App\Models\CardInfoModel;
use App\Models\ConfigPositionModel;
use App\Models\LawyerCaseModel;
use App\Models\LawyerInfoModel;
use App\Models\LawyerUserConsultationModel;
use App\Models\LawyerUserModel;
use App\Models\LogCardVisitModel;
use App\Models\LogLawyerAuthApplyModel;
use App\Models\LogTaskOperationModel;
use App\Models\LogUserFeedBackModel;
use App\Models\LogUserLoginModel;
use App\Models\LogUserPhoneBindModel;
use App\Models\LogUserVisitModel;
use App\Models\LogUserWxBindModel;
use App\Models\MessageRuleModel;
use App\Models\MessageUserModel;
use App\Models\NoticeContentTemplateModel;
use App\Models\NoticeModel;
use App\Models\NoticeParamModel;
use App\Models\PrivateLetterContentModel;
use App\Models\PrivateLetterModel;
use App\Models\ProjectInviteCodeModel;
use App\Models\ProjectModel;
use App\Models\RelNoticeUserModel;
use App\Models\StatusUserBindModel;
use App\Models\StrongPointModel;
use App\Models\TagModel;
use App\Models\TaskListModel;
use App\Models\TaskModel;
use App\Models\TasksRemindModel;
use App\Models\TeamAbilityModel;
use App\Models\TeamAboutModel;
use App\Models\TeamAchievementModel;
use App\Models\TeamLawyerModel;
use App\Models\TeamViewPointModel;
use App\Models\UserCardModel;
use App\Models\UserCoreModel;
use App\Models\UserInfoModel;
use App\Models\UserLoginModel;
use App\Models\UserRegisterModel;
use App\Models\UserTokenModel;
use App\Models\ResourceFileModel;
use App\Models\ResourceModel;
use App\Models\DocumentModel;
use App\Models\WebsiteColumnCarouselModel;
use App\Models\WebsiteColumnModel;
use App\Models\WebsiteColumnTeamAbilityModel;
use App\Models\WebsiteColumnTeamAboutModel;
use App\Models\WebsiteColumnTeamAchievementModel;
use App\Models\WebsiteColumnTeamModel;
use App\Models\WebsiteColumnTeamViewPointModel;
use App\Models\WebsiteModel;
use App\Models\ConfigAppModel;

class Model
{
    public $userInfoModel = null;
    public $userLoginModel = null;
    public $cardInfoModel = null;
    public $lawyerCaseModel = null;
    public $strongPointModel = null;
    public $userCardModel = null;
    public $lawyerUserModel = null;
    public $logCardVisitModel = null;
    public $logLawyerAuthApplyModel = null;
    public $userCoreModel = null;
    public $adeptTagModel = null;
    public $configPositionModel = null;
    public $lawyerInfoModel = null;
    public $taskModel = null;
    public $lawyerUserConsultationModel = null;
    public $logTaskOperationModel = null;
    public $logUserFeedBackModel = null;
    public $logUserLoginModel = null;
    public $logUserPhoneBindModel = null;
    public $logUserVisitModel = null;
    public $logUserWxBindModel = null;
    public $messageRuleModel = null;
    public $messageUserModel = null;
    public $noticeContentTemplateModel = null;
    public $noticeModel = null;
    public $noticeParamModel = null;
    public $privateLetterModel = null;
    public $privateLetterContentModel = null;
    public $projectModel = null;
    public $projectInviteCodeModel = null;
    public $relNoticeUserModel = null;
    public $tagModel = null;
    public $statusUserBindModel = null;
    public $taskListModel = null;
    public $tasksRemindModel = null;
    public $userRegisterModel = null;
    public $userTokenModel = null;
    public $resourceFileModel = null;
    public $resourceModel = null;
    public $documentModel = null;
    public $configAppModel = null;

    /**
     * 官网
     * @var WebsiteModel|null
     */
    public $websiteModel = null;


    /**
     * 官网栏目：律师业绩
     * @var WebsiteColumnTeamAchievementModel|null
     */
    public $websiteColumnTeamAchievementModel = null;

    /**
     * 官网栏目：关于我们
     * @var WebsiteColumnTeamAboutModel|null
     */
    public $websiteColumnTeamAboutModel = null;

    /**
     * 官网栏目：律师实力
     * @var WebsiteColumnTeamAbilityModel|null
     */
    public $websiteColumnTeamAbilityModel = null;

    /**
     * 官网栏目：团队
     * @var WebsiteColumnTeamModel|null
     */
    public $websiteColumnTeamModel = null;

    /**
     * 官网栏目：轮播
     * @var WebsiteColumnCarouselModel|null
     */
    public $websiteColumnCarouselModel = null;

    /**
     * 官网栏目：观点
     * @var WebsiteColumnTeamViewPointModel|null
     */
    public $websiteColumnTeamViewPointModel = null;

    /**
     * 官网：栏目
     * @var WebsiteColumnModel|null
     */
    public $websiteColumnModel = null;

    /**
     * 关于我们
     * @var TeamAboutModel|null
     */
    public $teamAboutModel = null;

    /**
     * 律师业绩
     * @var TeamAchievementModel|null
     */
    public $teamAchievementModel = null;

    /**
     * 律师官网观点
     * @var TeamViewPointModel|null
     */
    public $teamViewPointModel = null;

    /**
     * 律师团
     * @var TeamLawyerModel|null
     */
    public $teamLawyerModel = null;

    /**
     * 律师实力
     * @var TeamAbilityModel|null
     */
    public $teamAbilityModel = null;

    /**
     * 律师观点：文章标签
     * @var ArticleTagModel|null
     */
    public $articleTagModel = null;


    /**
     * Model constructor.
     * @param AdeptTagModel $adeptTagModel
     * @param UserLoginModel $userLoginModel
     * @param UserRegisterModel $userRegisterModel
     * @param UserCoreModel $userCoreModel
     * @param UserCardModel $userCardModel
     * @param UserTokenModel $userTokenModel
     * @param UserInfoModel $userInfoModel
     * @param ConfigPositionModel $configPositionModel
     * @param CardInfoModel $cardInfoModel
     * @param StrongPointModel $strongPointModel
     * @param LawyerUserModel $lawyerUserModel
     * @param LawyerCaseModel $lawyerCaseModel
     * @param LawyerInfoModel $lawyerInfoModel
     * @param LawyerUserConsultationModel $lawyerUserConsultationModel
     * @param LogTaskOperationModel $logTaskOperationModel
     * @param LogUserFeedBackModel $logUserFeedBackModel
     * @param LogUserLoginModel $logUserLoginModel
     * @param LogUserPhoneBindModel $logUserPhoneBindModel
     * @param LogUserVisitModel $logUserVisitModel
     * @param LogUserWxBindModel $logUserWxBindModel
     * @param LogCardVisitModel $logCardVisitModel
     * @param LogLawyerAuthApplyModel $logLawyerAuthApplyModel
     * @param MessageRuleModel $messageRuleModel
     * @param MessageUserModel $messageUserModel
     * @param NoticeContentTemplateModel $noticeContentTemplateModel
     * @param NoticeModel $noticeModel
     * @param NoticeParamModel $noticeParamModel
     * @param PrivateLetterModel $privateLetterModel
     * @param PrivateLetterContentModel $privateLetterContentModel
     * @param ProjectModel $projectModel
     * @param ProjectInviteCodeModel $projectInviteCodeModel
     * @param RelNoticeUserModel $relNoticeUserModel
     * @param StatusUserBindModel $statusUserBindModel
     * @param TagModel $tagModel
     * @param TaskListModel $taskListModel
     * @param TasksRemindModel $tasksRemindModel
     * @param ResourceFileModel $resourceFileModel
     * @param ResourceModel $resourceModel
     * @param DocumentModel $documentModel
     * @param WebsiteModel $websiteModel
     * @param WebsiteColumnTeamAchievementModel $websiteColumnTeamAchievementModel
     * @param WebsiteColumnTeamAboutModel $websiteColumnTeamAboutModel
     * @param WebsiteColumnTeamAbilityModel $websiteColumnTeamAbilityModel
     * @param WebsiteColumnTeamModel $websiteColumnTeamModel
     * @param WebsiteColumnCarouselModel $websiteColumnCarouselModel
     * @param WebsiteColumnTeamViewPointModel $websiteColumnTeamViewPointModel
     * @param WebsiteColumnModel $websiteColumnModel
     * @param TeamAboutModel $teamAboutModel
     * @param TeamAchievementModel $teamAchievementModel
     * @param TeamViewPointModel $teamViewPointModel
     * @param TeamLawyerModel $teamLawyerModel
     * @param TeamAbilityModel $teamAbilityModel
     * @param ArticleTagModel $articleTagModel
     * @param TaskModel $taskModel
     * @param ConfigAppModel $configAppModel
     */
    public function __construct
    (
        AdeptTagModel $adeptTagModel,
        UserLoginModel $userLoginModel,
        UserRegisterModel $userRegisterModel,
        UserCoreModel $userCoreModel,
        UserCardModel $userCardModel,
        UserTokenModel $userTokenModel,
        UserInfoModel $userInfoModel,
        ConfigPositionModel $configPositionModel,
        CardInfoModel $cardInfoModel,
        StrongPointModel $strongPointModel,
        LawyerUserModel $lawyerUserModel,
        LawyerCaseModel $lawyerCaseModel,
        LawyerInfoModel $lawyerInfoModel,
        LawyerUserConsultationModel $lawyerUserConsultationModel,
        LogTaskOperationModel $logTaskOperationModel,
        LogUserFeedBackModel $logUserFeedBackModel,
        LogUserLoginModel $logUserLoginModel,
        LogUserPhoneBindModel $logUserPhoneBindModel,
        LogUserVisitModel $logUserVisitModel,
        LogUserWxBindModel $logUserWxBindModel,
        LogCardVisitModel $logCardVisitModel,
        LogLawyerAuthApplyModel $logLawyerAuthApplyModel,
        MessageRuleModel $messageRuleModel,
        MessageUserModel $messageUserModel,
        NoticeContentTemplateModel $noticeContentTemplateModel,
        NoticeModel $noticeModel,
        NoticeParamModel $noticeParamModel,
        PrivateLetterModel $privateLetterModel,
        PrivateLetterContentModel $privateLetterContentModel,
        ProjectModel $projectModel,
        ProjectInviteCodeModel $projectInviteCodeModel,
        RelNoticeUserModel $relNoticeUserModel,
        StatusUserBindModel $statusUserBindModel,
        TagModel $tagModel,
        TaskListModel $taskListModel,
        TasksRemindModel $tasksRemindModel,
        TaskModel $taskModel,
        ResourceModel $resourceModel,
        ResourceFileModel $resourceFileModel,
        DocumentModel $documentModel,
        WebsiteModel $websiteModel,
        WebsiteColumnTeamAchievementModel $websiteColumnTeamAchievementModel,
        WebsiteColumnTeamAboutModel $websiteColumnTeamAboutModel,
        WebsiteColumnTeamAbilityModel $websiteColumnTeamAbilityModel,
        WebsiteColumnTeamModel $websiteColumnTeamModel,
        WebsiteColumnCarouselModel $websiteColumnCarouselModel,
        WebsiteColumnTeamViewPointModel $websiteColumnTeamViewPointModel,
        WebsiteColumnModel $websiteColumnModel,
        TeamAboutModel $teamAboutModel,
        TeamAchievementModel $teamAchievementModel,
        TeamViewPointModel $teamViewPointModel,
        TeamLawyerModel $teamLawyerModel,
        TeamAbilityModel $teamAbilityModel,
        ArticleTagModel $articleTagModel,
        ConfigAppModel $configAppModel
    )
    {
        $this->websiteModel = $websiteModel;
        $this->articleTagModel = $articleTagModel;
        $this->websiteColumnTeamAchievementModel = $websiteColumnTeamAchievementModel;
        $this->websiteColumnTeamAboutModel = $websiteColumnTeamAboutModel;
        $this->websiteColumnTeamAbilityModel = $websiteColumnTeamAbilityModel;
        $this->websiteColumnTeamModel = $websiteColumnTeamModel;
        $this->websiteColumnCarouselModel = $websiteColumnCarouselModel;
        $this->websiteColumnTeamViewPointModel = $websiteColumnTeamViewPointModel;
        $this->websiteColumnModel = $websiteColumnModel;
        $this->teamAboutModel = $teamAboutModel;
        $this->teamAchievementModel = $teamAchievementModel;
        $this->teamViewPointModel = $teamViewPointModel;
        $this->teamLawyerModel = $teamLawyerModel;
        $this->teamAbilityModel = $teamAbilityModel;
        $this->adeptTagModel = $adeptTagModel;
        $this->cardInfoModel = $cardInfoModel;
        $this->configPositionModel = $configPositionModel;
        $this->userInfoModel = $userInfoModel;
        $this->userLoginModel = $userLoginModel;
        $this->userRegisterModel = $userRegisterModel;
        $this->userTokenModel = $userTokenModel;
        $this->userCardModel = $userCardModel;
        $this->userCoreModel = $userCoreModel;
        $this->statusUserBindModel = $statusUserBindModel;
        $this->projectModel = $projectModel;
        $this->projectInviteCodeModel = $projectInviteCodeModel;
        $this->privateLetterContentModel = $privateLetterContentModel;
        $this->privateLetterModel = $privateLetterModel;
        $this->noticeModel = $noticeModel;
        $this->noticeParamModel = $noticeParamModel;
        $this->noticeContentTemplateModel = $noticeContentTemplateModel;
        $this->strongPointModel = $strongPointModel;
        $this->messageRuleModel = $messageRuleModel;
        $this->messageUserModel = $messageUserModel;
        $this->logTaskOperationModel = $logTaskOperationModel;
        $this->logUserPhoneBindModel = $logUserPhoneBindModel;
        $this->logUserFeedBackModel = $logUserFeedBackModel;
        $this->logUserVisitModel = $logUserVisitModel;
        $this->logUserLoginModel = $logUserLoginModel;
        $this->logUserWxBindModel = $logUserWxBindModel;
        $this->logCardVisitModel = $logCardVisitModel;
        $this->logLawyerAuthApplyModel = $logLawyerAuthApplyModel;
        $this->lawyerUserConsultationModel = $lawyerUserConsultationModel;
        $this->lawyerCaseModel = $lawyerCaseModel;
        $this->lawyerUserModel = $lawyerUserModel;
        $this->lawyerInfoModel = $lawyerInfoModel;
        $this->tagModel = $tagModel;
        $this->taskListModel = $taskListModel;
        $this->tasksRemindModel = $tasksRemindModel;
        $this->taskModel = $taskModel;
        $this->relNoticeUserModel = $relNoticeUserModel;
        $this->resourceModel = $resourceModel;
        $this->resourceFileModel = $resourceFileModel;
        $this->documentModel = $documentModel;
        $this->configAppModel = $configAppModel;
    }



}
