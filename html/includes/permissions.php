<?php

enum Permission: string
{
    case ADD_PAYMENT = "add_payment";
    case EDIT_AUCTION = "edit_auction";
    case VIEW_AUCTION = "view_auction";
    case SET_PASSWORD = "set_password";
    case VIEW_MEMBER = "view_member";
    case EDIT_PERMISSIONS = "edit_permissions";
    case VIEW_MEMBER_LIST = "view_member_list";
    case EDIT_REG = "edit_reg";
    case VIEW_MEMBER_EXT = "view_member_ext";
    case VIEW_REG = "view_reg";
    case VIEW_REG_LIST = "view_reg_list";
    case EDIT_MEMBER = "edit_member";

    public function description() : string {
        return match($this) {
            self::ADD_PAYMENT => "Add payment",
            self::EDIT_AUCTION => "Edit auction information",
            self::VIEW_AUCTION => "View auction information",
            self::SET_PASSWORD => "Set password",
            self::VIEW_MEMBER => "View member information",
            self::EDIT_PERMISSIONS => "Edit permissions",
            self::VIEW_MEMBER_LIST => "View list of members",
            self::EDIT_REG => "Edit registration",
            self::VIEW_MEMBER_EXT => "View extended member information",
            self::VIEW_REG => "View registrations",
            self::VIEW_REG_LIST => "View list of registrations",
            self::EDIT_MEMBER => "Edit member information",
        };
    }
}