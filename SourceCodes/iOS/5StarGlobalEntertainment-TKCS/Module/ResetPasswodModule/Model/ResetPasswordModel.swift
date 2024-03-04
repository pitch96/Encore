//
//  ResetPasswordModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 30/11/22.
//

import Foundation
struct ResetPasswordModel: Codable {
    let statusCode: Int?
    let success: Bool?
    let message: String?
}

struct ResendPassword: Codable {
    let statusCode: Int?
    let success: Bool?
    let message: String?
    let data: [JSONAny]?
}
