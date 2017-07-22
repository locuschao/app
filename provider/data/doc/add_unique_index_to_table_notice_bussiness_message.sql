#说明：notice_bussiness_message表添加唯一索引IDX_nbm_code
#时间：2016-11-02 13:55

ALTER TABLE `notice_bussiness_message` ADD UNIQUE `UNI_nbm_code` (`nbm_code`);