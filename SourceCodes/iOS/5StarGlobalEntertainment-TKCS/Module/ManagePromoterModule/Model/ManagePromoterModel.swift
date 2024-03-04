//
//  ManagePromoterModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/01/23.
//

import Foundation
// MARK: - Promoter Model
struct ManagePromoterModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [ManagePromoterDetail]?
}

// MARK: - Manage Promoter Detail
struct ManagePromoterDetail: Codable {
    var id, userType: Int?
    var firstName, lastName, email, phoneNo: String?
    var companyName: String?
    var emailVerifiedAt: String?
    var status: Int?
    var userProfile: String?
    var isVerified: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?
    var isEmailVerified: Int?

    enum CodingKeys: String, CodingKey {
        case id
        case userType = "user_type"
        case firstName = "first_name"
        case lastName = "last_name"
        case email
        case phoneNo = "phone_no"
        case companyName = "company_name"
        case emailVerifiedAt = "email_verified_at"
        case status
        case userProfile = "user_profile"
        case isVerified
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case isEmailVerified = "is_email_verified"
    }
}
// MARK: - Delete Promoter
struct DeletePromoterModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
}
// MARK: - Promoter status change model
struct PromoterStatusModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: PromoterStatusDetails?
}
struct PromoterStatusDetails: Codable {
    var status, message: String?
}
